<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 12/03/19
 * Time: 15:50
 */

namespace App\Service;

use App\Entity\RentRelease;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Snappy\Pdf;
use Twig\Environment;
/**
 * Class PdfGenerator
 * @package App\Service
 */
class PdfGenerator
{
    /**
     * @var Pdf
     */
    private $knpSnappyPdf;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * PdfGenerator constructor.
     * @param Pdf $knpSnappyPdf
     * @param Environment $environment
     * @param ObjectManager $manager
     */
    public function __construct(Pdf $knpSnappyPdf, Environment $environment, ObjectManager $manager)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->manager = $manager;
        $this->environment = $environment;
    }

    /**
     * Deleting accents from a string
     * @param string $string
     * @param string $charset
     * @return string
     */
    private function removeAccents(string $string, $charset = 'utf-8') :string
    {
        $string = htmlentities($string, ENT_NOQUOTES, $charset);
        $string = preg_replace(
            '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#',
            '\1',
            $string
        );
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string);
        $string = preg_replace('#&[^;]+;#', '', $string);
        $string = iconv('UTF-8', 'US-ASCII//TRANSLIT', $string);

        return $string;
    }

    /**
     * @param RentRelease $rentRelease
     * @throws \Exception
     */
    public function generateRentReleasePdf(RentRelease $rentRelease)
    {
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('m-Y');

        if ($rentRelease->getStatus() === RentRelease::STATUS_PAID) {
            $propertyName = $rentRelease->getPropertyName();
            $propertyName= str_replace(' ', '_', $propertyName);

            $lesseeName = str_replace(' ', '-', $rentRelease->getLesseeName());
            $fileName = $propertyName . '_' . $lesseeName . '_' . date("m-Y") . '_';
            $fileName = $fileName . bin2hex(random_bytes(5)) . '.pdf';
            $fileName = $this->removeAccents($fileName);

            $html = $this->environment->render('rent_release/pdf.html.twig', [
                'rent_release' => $rentRelease,
                'current_date' => $currentDate,
            ]);

            $this->knpSnappyPdf->generateFromHtml("$html", "generated/pdf/$fileName");

            $rentRelease->setPdf($fileName);
            $this->manager->persist($rentRelease);
        }
    }
}

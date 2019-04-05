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
use Twig_Environment;

class PdfGenerator
{
    /**
     * @var Pdf
     */
    private $knpSnappyPdf;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * PdfGenerator constructor.
     * @param Pdf $knpSnappyPdf
     * @param Twig_Environment $twig
     * @param ObjectManager $manager
     */
    public function __construct(Pdf $knpSnappyPdf, Twig_Environment $twig, ObjectManager $manager)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->twig = $twig;
        $this->manager = $manager;
    }

    /**
     * Deleting accents from a string
     * @param string $str
     * @param string $charset
     * @return string
     */
    private function removeAccents(string $str, $charset='utf-8') :string
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset );
        $str = preg_replace(
            '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#',
            '\1',
            $str
        );
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        $str = iconv('UTF-8', 'US-ASCII//TRANSLIT', $str);

        return $str;
    }

    /**
     * @param RentRelease $rentRelease
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function generateRentReleasePdf(RentRelease $rentRelease)
    {
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('m-Y');

        if ($rentRelease->getStatus() === 'Payé') {
            $propertyName = $rentRelease->getPropertyName();
            $propertyName= str_replace(' ', '_', $propertyName);

            $lesseeName = str_replace(' ', '-', $rentRelease->getLesseeName());
            $fileName = $propertyName . '_' . $lesseeName . '_' . date("m-Y") . '_';
            $fileName = $this->removeAccents($fileName);
            $fileName = $fileName . bin2hex(random_bytes(5)) . '.pdf';

            $html = $this->twig->render('rent_release/pdf.html.twig', [
                'rent_release' => $rentRelease,
                'current_date' => $currentDate,
            ]);

            $this->knpSnappyPdf->generateFromHtml("$html", "generated/pdf/$fileName");

            $rentRelease->setPdf($fileName);
            $this->manager->persist($rentRelease);
            $this->manager->flush();
        }
    }
}

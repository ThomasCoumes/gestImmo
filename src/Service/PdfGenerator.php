<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 12/03/19
 * Time: 15:50
 */

namespace App\Service;

use App\Entity\RentRelease;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
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
     * @param RentRelease $rentRelease
     */
    public function generateRentReleasePdf(RentRelease $rentRelease)
    {
            $currentDate = new \DateTime();
            $currentDate = $currentDate->format('m-Y');

            if ($rentRelease->getStatus() === 'Payé') {
                $propertyName = $rentRelease->getPropertyName();
                $lesseeName = str_replace(' ', '-', $rentRelease->getLesseeName());
                $fileName = $propertyName . '_' . $lesseeName . '_' . date("m-Y") . '_';
                $fileName = $fileName . bin2hex(random_bytes(5)) . '.pdf';

                $html = $this->twig->render('rent_release/pdf.html.twig', [
                    'rent_release' => $rentRelease,
                    'current_date' => $currentDate,
                ]);

                new PdfResponse(
                    $this->knpSnappyPdf->generateFromHtml($html, "generated/pdf/$fileName", [
                        'user-style-sheet' => ['./build/app.css'],
                    ])
                );

                $rentRelease->setPdf($fileName);
                $this->manager->persist($rentRelease);
                $this->manager->flush();
            }
    }
}
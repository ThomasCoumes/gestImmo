<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 11/03/19
 * Time: 10:43
 */

namespace App\Service;

use App\Repository\RentReleaseRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;

class PdfGenerator
{
    /**
     * @var Pdf
     */
    private $knpSnappyPdf;

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var RentReleaseRepository
     */
    private $rentReleaseRepository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(
        RentReleaseRepository $rentReleaseRepository,
        Pdf $knpSnappyPdf,
        \Twig_Environment $twig,
        ObjectManager $manager
    ) {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->twig = $twig;
        $this->rentReleaseRepository = $rentReleaseRepository;
        $this->manager = $manager;
    }

    public function generateRentReleasePdf()
    {
        $rentRelease = $this->rentReleaseRepository->findAll();

        foreach ($rentRelease as $release) {
            $date = $release->getDate()->format('m-Y');
            $currentDate = new \DateTime();
            $currentDate = $currentDate->format('m-Y');

            if ($date === $currentDate) {
                $propertyName = $release->getPropertyName();
                $lesseeName = str_replace(' ', '-', $release->getLesseeName());
                $fileName = $propertyName . '_' . $lesseeName . '_' . date("m-Y") . '_';
                $fileName = $fileName . bin2hex(random_bytes(5)) . '.pdf';

                $html = $this->twig->render('rent_release/pdf.html.twig', [
                    'rent_release' => $release,
                ]);

                new PdfResponse(
                    $this->knpSnappyPdf->generateFromHtml($html, "public/generated/pdf/$fileName", [
                        'user-style-sheet' => ['./build/app.css'],
                    ])
                );

                $release->setPdf($fileName);
                $this->manager->persist($release);
                $this->manager->flush();

                sleep(1);
            }
        }

        return null;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 11/03/19
 * Time: 10:43
 */

namespace App\Service;

use App\Entity\RentRelease;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;

class PdfGenerator
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var Pdf
     */
    private $knpSnappyPdf;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(
        PropertyRepository $propertyRepository,
        Pdf $knpSnappyPdf,
        EntityManagerInterface $em,
        \Twig_Environment $twig
    ) {
        $this->propertyRepository = $propertyRepository;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->em = $em;
        $this->twig = $twig;
    }

    public function generateRentReleasePdf()
    {
        $rentRelease = $this->em->getRepository(RentRelease::class)->findAll();

        foreach ($rentRelease as $release) {
            $date = $release->getDate()->format('m-Y');
            $currentDate = new \DateTime();
            $currentDate = $currentDate->format('m-Y');
            if ($date === $currentDate) {
                $propertyName = $release->getPropertyName();
                $lesseeName = str_replace(' ', '-', $release->getLesseeName());
                $fileName = $propertyName . '_' . $lesseeName . '_' . date("m-Y");

                $html = $this->twig->render('rent_release/pdf.html.twig', [
                    'rent_release' => $release,
                ]);

                return new PdfResponse(
                    $this->knpSnappyPdf->generateFromHtml($html, "public/generated/pdf/$fileName" . '.pdf', [
                        'user-style-sheet' => ['./build/app.css'],
                    ])
                );
            } else {
                return null;
            }
        }
    }
}

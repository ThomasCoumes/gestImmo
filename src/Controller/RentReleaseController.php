<?php

namespace App\Controller;

use App\Entity\RentRelease;
use App\Repository\RentReleaseRepository;
use App\Service\MonthlyMailer;
use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/loyers")
 * @IsGranted("ROLE_USER")
 */
class RentReleaseController extends AbstractController
{
    /**
     * @Route(name="rent_release_index", methods={"GET"})
     * @param RentReleaseRepository $rentReleaseRepository
     * @return Response
     */
    public function index(RentReleaseRepository $rentReleaseRepository): Response
    {
        return $this->render('rent_release/index.html.twig', [
            'rent_releases' => $rentReleaseRepository->findBy(
                ['userRentRelease' => $this->getUser()]
            ),
        ]);
    }

    /**
     * @Route("/{id}", name="rent_release_show", methods={"GET"})
     * @param RentRelease $rentRelease
     * @return Response
     */
    public function show(RentRelease $rentRelease): Response
    {
        if (!$this->isGranted('SHOW_RENT_RELEASE', $rentRelease)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('rent_release_index');
        }

        return $this->render('rent_release/show.html.twig', [
            'rent_release' => $rentRelease,
        ]);
    }

    /**
     * @Route("/{id}/paid", name="rent_release_paid", methods={"GET"})
     * @param RentRelease $rentRelease
     * @param PdfGenerator $pdfGenerator
     * @param MonthlyMailer $monthlyMailer
     * @return Response
     */
    public function rentIsPaid(
        RentRelease $rentRelease,
        PdfGenerator $pdfGenerator,
        MonthlyMailer $monthlyMailer
    ): Response {
        if (!$this->isGranted('EDIT_RENT_RELEASE', $rentRelease)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('rent_release_index');
        }

        $rentRelease->setStatus('Payé');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rentRelease);
        $entityManager->flush();

        $pdfGenerator->generateRentReleasePdf($rentRelease);

        //TODO SEND EMAIL WITH PDF TO LESSEES ASSIGNED TO A PROPERTY

        //TODO DELETE PDF FILE

        return $this->redirectToRoute('rent_release_index');
    }
}

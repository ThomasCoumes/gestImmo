<?php

namespace App\Controller;

use App\Entity\RentRelease;
use App\Repository\RentReleaseRepository;
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
     * @Route("/", name="rent_release_index", methods={"GET"})
     * @param RentReleaseRepository $rentReleaseRepository
     * @return Response
     */
    public function index(RentReleaseRepository $rentReleaseRepository): Response
    {
        return $this->render('rent_release/index.html.twig', [
            'rent_releases' => $rentReleaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="rent_release_show", methods={"GET"})
     * @param RentRelease $rentRelease
     * @return Response
     */
    public function show(RentRelease $rentRelease): Response
    {
        return $this->render('rent_release/show.html.twig', [
            'rent_release' => $rentRelease,
        ]);
    }
}

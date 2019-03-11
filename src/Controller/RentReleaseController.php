<?php

namespace App\Controller;

use App\Entity\RentRelease;
use App\Form\RentReleaseType;
use App\Repository\RentReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    //TODO EDIT STATUS METHOD
    /**
     * @Route("/{id}/editer", name="rent_release_edit", methods={"GET","POST"})
     * @param Request $request
     * @param RentRelease $rentRelease
     * @return Response
     */
    public function edit(Request $request, RentRelease $rentRelease): Response
    {
        if (!$this->isGranted('EDIT_RENT_RELEASE', $rentRelease)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('rent_release_index');
        }

        $form = $this->createForm(RentReleaseType::class, $rentRelease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rent_release_index', [
                'id' => $rentRelease->getId(),
            ]);
        }

        return $this->render('rent_release/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

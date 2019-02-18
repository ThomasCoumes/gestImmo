<?php

namespace App\Controller;

use App\Entity\Lessee;
use App\Form\LesseeType;
use App\Repository\LesseeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/lessee")
 * @IsGranted("ROLE_USER")
 */
class LesseeController extends AbstractController
{
    /**
     * @Route("/", name="lessee_index", methods={"GET"})
     */
    public function index(LesseeRepository $lesseeRepository): Response
    {
        return $this->render('lessee/index.html.twig', [
            'lessees' => $lesseeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lessee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lessee = new Lessee();
        $form = $this->createForm(LesseeType::class, $lessee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lessee);
            $entityManager->flush();

            return $this->redirectToRoute('lessee_index');
        }

        return $this->render('lessee/new.html.twig', [
            'lessee' => $lessee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lessee_show", methods={"GET"})
     */
    public function show(Lessee $lessee): Response
    {
        return $this->render('lessee/show.html.twig', [
            'lessee' => $lessee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lessee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lessee $lessee): Response
    {
        $form = $this->createForm(LesseeType::class, $lessee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lessee_index', [
                'id' => $lessee->getId(),
            ]);
        }

        return $this->render('lessee/edit.html.twig', [
            'lessee' => $lessee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lessee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lessee $lessee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lessee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lessee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lessee_index');
    }
}

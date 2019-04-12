<?php

namespace App\Controller;

use App\Entity\RentRelease;
use App\Repository\RentReleaseRepository;
use App\Service\MonthlyMailer;
use App\Service\PdfGenerator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class RentReleaseController
 * @package App\Controller
 * @Route("/loyers")
 * @IsGranted("ROLE_USER")
 */
class RentReleaseController extends AbstractController
{
    /**
     * @Route(name="rent_release_index", methods={"GET"})
     * @param RentReleaseRepository $rentReleaseRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(
        RentReleaseRepository $rentReleaseRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $paginator->paginate(
            $rentReleaseRepository->findByUserQuery($this->getUser()),
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('rent_release/index.html.twig', [
            'rent_releases' => $query,
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
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
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
        $monthlyMailer->sendRentReleaseToLessees($rentRelease);

        $filesystem = new Filesystem();

        $pdfFile = $rentRelease->getPdf();
        $filesystem->remove("generated/pdf/$pdfFile");

        $entityManager = $this->getDoctrine()->getManager();

        $rentRelease->setPdf(null);

        $entityManager->persist($rentRelease);
        $entityManager->flush();

        return $this->redirectToRoute('rent_release_index');
    }
}

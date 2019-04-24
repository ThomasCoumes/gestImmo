<?php

namespace App\Controller;

use App\Entity\RentRelease;
use App\Events;
use App\EventSubscriber\EmailingEvent;
use App\Repository\RentReleaseRepository;
use App\Service\MonthlyMailer;
use App\Service\PdfGenerator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/paid/{id}", name="rent_release_paid", methods={"GET"})
     * @param RentRelease $rentRelease
     * @param PdfGenerator $pdfGenerator
     * @param MonthlyMailer $monthlyMailer
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function rentIsPaid(
        RentRelease $rentRelease,
        PdfGenerator $pdfGenerator,
        MonthlyMailer $monthlyMailer,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        if (!$this->isGranted('EDIT_RENT_RELEASE', $rentRelease)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('rent_release_index');
        }

        $rentRelease->setStatus(RentRelease::STATUS_PAID);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rentRelease);

        $pdfGenerator->generateRentReleasePdf($rentRelease);
        $monthlyMailer->sendRentReleaseToLessees($rentRelease);

        $event = new EmailingEvent($rentRelease);

        $eventDispatcher->dispatch(Events::EMAIL_SENT, $event);

        $entityManager->flush();

        return $this->redirectToRoute('rent_release_index');
    }
}

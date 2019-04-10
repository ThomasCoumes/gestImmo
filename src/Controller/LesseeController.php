<?php

namespace App\Controller;

use App\Entity\Lessee;
use App\Form\LesseeType;
use App\Repository\LesseeRepository;
use App\Service\LesseeCapitalizeFirstLetter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class LesseeController
 * @package App\Controller
 * @Route("/locataires")
 * @IsGranted("ROLE_USER")
 */
class LesseeController extends AbstractController
{
    /**
     * @Route(name="lessee_index", methods={"GET"})
     * @param LesseeRepository $lesseeRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(LesseeRepository $lesseeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $paginator->paginate(
            $lesseeRepository->findLesseeByUserQuery($this->getUser()),
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('lessee/index.html.twig', [
            'lessees' => $query,
        ]);
    }

    /**
     * @Route("/ajouter", name="lessee_new", methods={"GET","POST"})
     * @param Request $request
     * @param LesseeCapitalizeFirstLetter $lesseeCapitalizeFirstLetter
     * @return Response
     */
    public function new(Request $request, LesseeCapitalizeFirstLetter $lesseeCapitalizeFirstLetter): Response
    {
        $lessee = new Lessee();
        $form = $this->createForm(LesseeType::class, $lessee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessee->setUserLessee($this->getUser());

            $lesseeCapitalizeFirstLetter->capitalizeFirstLetter($form, $lessee);

            return $this->redirectToRoute('lessee_index');
        }

        return $this->render('lessee/new.html.twig', [
            'lessee' => $lessee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lessee_show", methods={"GET"})
     * @param Lessee $lessee
     * @return Response
     */
    public function show(Lessee $lessee): Response
    {
        if (!$this->isGranted('SHOWLESSEE', $lessee)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('lessee_index');
        }

        return $this->render('lessee/show.html.twig', [
            'lessee' => $lessee,
        ]);
    }

    /**
     * @Route("/{id}/editer", name="lessee_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Lessee $lessee
     * @param LesseeCapitalizeFirstLetter $lesseeCapitalizeFirstLetter
     * @return Response
     */
    public function edit(
        Request $request,
        Lessee $lessee,
        LesseeCapitalizeFirstLetter $lesseeCapitalizeFirstLetter
    ): Response {
        if (!$this->isGranted('EDITLESEE', $lessee)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('lessee_index');
        }

        $form = $this->createForm(LesseeType::class, $lessee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $lesseeCapitalizeFirstLetter->capitalizeFirstLetter($form, $lessee);

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
     * @param Request $request
     * @param Lessee $lessee
     * @return Response
     */
    public function delete(Request $request, Lessee $lessee): Response
    {
        if (!$this->isGranted('DELETELESEE', $lessee)) {
            $this->addFlash('danger', 'Vous n\'etes pas autorisé à effectuer cette action.');

            return $this->redirectToRoute('lessee_index');
        }

        if ($this->isCsrfTokenValid('delete'.$lessee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lessee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lessee_index');
    }

    /**
     * @Route("/invitation-de-locataire/{lessee_id}", name="lessee_invitation", methods={"GET","POST"})
     * @ParamConverter("lessee", class="App\Entity\Lessee", options={"mapping": {"lessee_id" : "id"}})
     * @param Lessee $lessee
     * @param UserInterface $user
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws \Exception
     */
    public function inviteLesseeByEmail(Lessee $lessee, UserInterface $user, \Swift_Mailer $mailer): Response
    {
        $lesseeName = $lessee->getName();
        $userIdentity = $user->getName() . ' ' . $user->getLastName();
        $lesseeEmail = $lessee->getEmail();

        // generate a random 200 char token and set him to lessee
        $invitationToken =  bin2hex(random_bytes(100));
        $lessee->setInvitationToken($invitationToken);

        $em = $this->getDoctrine()->getManager();
        $em->persist($lessee);
        $em->flush();

        $message = (new \Swift_Message($userIdentity . ' ' . 'vous invite à rejoindre l\'application gestImmo'))
            ->setFrom(getenv('MAILER_FROM_ADDRESS'))
            ->setTo($lesseeEmail)
            ->setBody(
                $this->renderView(
                    'emails/lesseeInvitation.html.twig',
                    [
                        'userIdentity' => $userIdentity,
                        'lesseeName' => $lesseeName,
                        'invitationToken' => $invitationToken,
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->redirectToRoute('lessee_index');
    }
}

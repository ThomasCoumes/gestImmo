<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EmailCheckingType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('property_index');
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/inscription", name="registration")
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(
        Request $request,
        ObjectManager $objectManager,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $user->setRoles(["ROLE_USER"]);

            $objectManager->persist($user);
            $objectManager->flush();

            $this->addFlash('success', 'Votre compte a été enregistré, vous pouvez vous connecter');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/resetPassword", name="reset_password")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function checkEmailExistance(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(EmailCheckingType::class);

        $form->handleRequest($request);

        $user = $em->getRepository(User::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formEmail = $data->getEmail();

            if (!$user->findOneBy(['email' => $formEmail])) {
                $this->addFlash('danger', 'Nous n\'avons pas trouvé votre adresse email');
            } else {
                $this->addFlash('success', 'Nous avons trouvé votre adresse email');

                //TODO SEND AN EMAIL
            }
        }

        return $this->render('security/emailChecking.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
}

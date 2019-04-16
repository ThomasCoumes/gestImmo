<?php

namespace App\Controller;

use App\Entity\Lessee;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\EmailCheckingType;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
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
            return $this->redirectToRoute('home');
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
     * @Route("/contactez-moi", name="sendResetPasswordEmail")
     * @param Request $request
     * @param EntityManagerInterface $emInterface
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function sendResetPasswordEmail(Request $request, EntityManagerInterface $emInterface, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(EmailCheckingType::class);

        $form->handleRequest($request);

        $user = $emInterface->getRepository(User::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formEmail = $data->getEmail();

            $potentialUser = $user->findOneBy(['email' => $formEmail]);

            if (!$potentialUser) {
                $this->addFlash('danger', 'Nous n\'avons pas trouvé votre adresse email');
            } else {
                $this->addFlash(
                    'success',
                    'Veuillez cliquer sur le lien que nous vous avons envoyé par mail'
                );

                //generate token (160 characters) then set him to user corresponding to the email

                $name = $potentialUser->getName();

                $token = bin2hex(random_bytes(80));
                $potentialUser->setToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($potentialUser);
                $em->flush();

                $message = (new \Swift_Message('Reinitialisez votre mot de passe gestImmo'))
                    ->setFrom(getenv('MAILER_FROM_ADDRESS'))
                    ->setTo($formEmail)
                    ->setBody(
                        $this->renderView(
                            'emails/emailResetPassword.html.twig',
                            [
                                'name' => $name,
                                'token' => $token,
                            ]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('security/emailChecking.html.twig', [
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/changer-mot-de-passe/{token}", name="resetPassword")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $emInterface
     * @return Response
     */
    public function resetPassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $emInterface
    ) {
        $em = $this->getDoctrine()->getManager();

        $token = str_replace('/changer-mot-de-passe/', '', $request->getPathInfo());

        $user = $emInterface->getRepository(User::class);
        $confirmedUser = $user->findOneBy(['token' => $token]);

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formPassword = $data->getNewPlainPassword();

            $newEncodedPassword = $encoder->encodePassword($confirmedUser, $formPassword);
            $confirmedUser->setPassword($newEncodedPassword);

            $confirmedUser->setToken(null);

            $em->persist($confirmedUser);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été enregistré');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/resetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/change-password", name="password-change")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function change(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formPassword = $data['password'];

            if ($encoder->isPasswordValid($user, $formPassword)) {
                $newPlainPassword = $data['newPassword'];
                $newEncodedPassword = $encoder->encodePassword($user, $newPlainPassword);
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été enregistré');

                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('danger', 'Mot de passe actuel incorrect');
            }
        }

        return $this->render('security/changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription/{invitationToken}", name="lesseeRegistration")
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $emInterface
     * @return Response
     */
    public function lesseeRegistration(
        Request $request,
        ObjectManager $objectManager,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $emInterface
    ): Response {
        $user = new User();

        $invitationToken = str_replace('/inscription/', '', $request->getPathInfo());

        $lessee = $emInterface->getRepository(Lessee::class);
        $registringLessee = $lessee->findOneBy(['invitationToken' => $invitationToken]);

        $email = $registringLessee->getEmail();
        $name = $registringLessee->getName();
        $lastName = $registringLessee->getLastName();

        $user->setEmail($email);
        $user->setName($name);
        $user->setLastName($lastName);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $user->setRoles(["ROLE_LESSEE"]);

            $registringLessee->setInvitationToken(null);

            $objectManager->persist($registringLessee);
            $objectManager->persist($user);
            $objectManager->flush();

            $this->addFlash('success', 'Votre compte a été enregistré, vous pouvez vous connecter');

            return $this->redirectToRoute('app_login');
        }
        dd($this);

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

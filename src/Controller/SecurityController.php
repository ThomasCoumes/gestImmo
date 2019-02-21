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
     * @Route("/contactez-moi", name="sendResetPasswordEmail")
     * @param Request $request
     * @param EntityManagerInterface $emInterface
     * @param \Swift_Mailer $mailer
     * @return Response
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
                    'Veuillez cliquer sur le lien que nous vous avons envoyé par mail');

                //generate token (160 characters) then set him to user corresponding to the email
                $token = bin2hex(random_bytes(80));
                $potentialUser->setToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($potentialUser);
                $em->flush();

                $name = $potentialUser->getName();

                $message = (new \Swift_Message('Hello Email'))
                    //put the email adress you defined in .env.local here
                    ->setFrom('thomascoumes3145@gmail.com')
                    ->setTo($formEmail)
                    ->setBody(
                        $this->renderView(
                            'emails/emailResetPassword.html.twig',
                            ['name' => $name]
                        ),
                        'text/html'
                    );

                $mailer->send($message);
//                return $this->redirectToRoute('');
            }
        }

        return $this->render('security/emailChecking.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 12/03/19
 * Time: 11:17
 */

namespace App\Service;

use App\Entity\RentRelease;
use App\Repository\LesseeRepository;
use Swift_Attachment;
use Swift_Mailer;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

class MonthlyMailer
{
    /**
     * @var LesseeRepository
     */
    private $lesseeRepository;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * MonthlyMailer constructor.
     * @param LesseeRepository $lesseeRepository
     * @param Swift_Mailer $mailer
     * @param Twig_Environment $twig
     * @param RouterInterface $router
     */
    public function __construct(
        LesseeRepository $lesseeRepository,
        Swift_Mailer $mailer,
        Twig_Environment $twig,
        RouterInterface $router
    ) {
        $this->lesseeRepository = $lesseeRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function notifyOwner()
    {
        $context = $this->router->getContext();
        // $context elements are defined in services.yaml under parameters:
        $url = sprintf(
            '%s://%s%s',
            $context->getScheme(),
            $context->getHost(),
            $this->router->generate('rent_release_index')
        );

        $lesseeRepository = $this->lesseeRepository->findAll();
        $mailList = [];
        foreach ($lesseeRepository as $lessee) {
            $mails = $lessee->getUserLessee()->getEmail();
            if (!in_array($mails, $mailList)) {
                $mailList[] = $mails;
            }
        }

        foreach ($mailList as $mail) {
            $message = (new \Swift_Message('Nous avons generer vos loyers !'))
                ->setFrom(getenv('MAILER_FROM_ADDRESS'))
                ->setTo("$mail")
                ->setBody(
                    $this->twig->render(
                        'rent_release/emailOwner.html.twig',
                        [
                            'url' => $url,
                        ]
                    ),
                    'text/html'
                );
            $this->mailer->send($message);
        }

        return true;
    }

    public function sendRentReleaseToLessees(RentRelease $rentRelease)
    {
        $mail = $rentRelease->getRentRelease()->getEmail();

        $name = $rentRelease->getLesseeName();
        $owner = $rentRelease->getUserRentRelease()->getName();
        $owner = $owner . ' ' . $rentRelease->getUserRentRelease()->getLastName();
        $property = $rentRelease->getPropertyName();

        $pdf = $rentRelease->getPdf();

        $message = (new \Swift_Message('Votre quittance de loyer'))
            ->setFrom(getenv('MAILER_FROM_ADDRESS'))
            ->setTo("$mail")
            ->setBody(
                $this->twig->render(
                    'rent_release/rentReleaseMail.html.twig',
                    [
                        'name' => $name,
                        'owner' => $owner,
                        'property' => $property,
                    ]
                ),
                'text/html'
            )
            ->attach(Swift_Attachment::fromPath("generated/pdf/$pdf"));

        $this->mailer->send($message);
    }
}

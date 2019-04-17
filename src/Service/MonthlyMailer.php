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
use Twig\Environment;

/**
 * Class MonthlyMailer
 * @package App\Service
 */
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
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * MonthlyMailer constructor.
     * @param LesseeRepository $lesseeRepository
     * @param Swift_Mailer $mailer
     * @param Environment $environment
     * @param RouterInterface $router
     */
    public function __construct(
        LesseeRepository $lesseeRepository,
        Swift_Mailer $mailer,
        Environment $environment,
        RouterInterface $router
    ) {
        $this->lesseeRepository = $lesseeRepository;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->environment = $environment;
    }

    /**
     * @return bool
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifyOwner() :bool
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
                    $this->environment->render(
                        'emails/emailOwner.html.twig',
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

    /**
     * @param RentRelease $rentRelease
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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
                $this->environment->render(
                    'emails/rentReleaseMail.html.twig',
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

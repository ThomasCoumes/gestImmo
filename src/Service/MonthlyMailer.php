<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 12/03/19
 * Time: 11:17
 */

namespace App\Service;

use App\Repository\LesseeRepository;
use Swift_Mailer;
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
     * MonthlyMailer constructor.
     * @param LesseeRepository $lesseeRepository
     * @param Swift_Mailer $mailer
     * @param Twig_Environment $twig
     */
    public function __construct(LesseeRepository $lesseeRepository, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->lesseeRepository = $lesseeRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notifyOwner()
    {
        $lesseeRepository = $this->lesseeRepository->findAll();
        $mailList = [];
        foreach ($lesseeRepository as $lessee) {
            $mails = $lessee->getUserLessee()->getEmail();
            $name = $lessee->getUserLessee()->getName();
            if (!in_array($mails, $mailList)) {
                $mailList[] = $mails;
            }
        }

        foreach ($mailList as $mail) {
            $message = (new \Swift_Message('Nous avons generer vos loyers !'))
                // set the email you defined in .env.local here
                ->setFrom('thomascoumes3145@gmail.com')
                ->setTo("$mail")
                ->setBody(
                    $this->twig->render(
                        'rent_release/emailOwner.html.twig'
                    ),
                    'text/html'
                );
            $this->mailer->send($message);
        }

        return true;
    }
}

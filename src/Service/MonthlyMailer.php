<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 12/03/19
 * Time: 11:17
 */

namespace App\Service;

use App\Repository\LesseeRepository;

class MonthlyMailer
{
    /**
     * @var LesseeRepository
     */
    private $lesseeRepository;

    /**
     * MonthlyMailer constructor.
     * @param LesseeRepository $lesseeRepository
     */
    public function __construct(LesseeRepository $lesseeRepository)
    {
        $this->lesseeRepository = $lesseeRepository;
    }

    public function notifyOwner()
    {
        $lesseeRepository = $this->lesseeRepository->findAll();
        $mailList = [];
        foreach ($lesseeRepository as $lessee) {
            $mails = $lessee->getUserLessee()->getEmail();
            if (!in_array($mails, $mailList)) {
                $mailList[] = $mails;
            }
        }

        dump($mailList);

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 07/03/19
 * Time: 14:05
 */

namespace App\Command;

use App\Service\MonthlyMailer;
use App\Service\RentReleaseInsertion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RentReleaseCommand extends Command
{
    /**
     * @var RentReleaseInsertion
     */
    private $rentReleaseInsertion;
    /**
     * @var MonthlyMailer
     */
    private $mailer;

    /**
     * RentReleaseCommand constructor.
     * @param RentReleaseInsertion $rentReleaseInsertion
     * @param MonthlyMailer $mailer
     */
    public function __construct(RentReleaseInsertion $rentReleaseInsertion, MonthlyMailer $mailer)
    {
        $this->rentReleaseInsertion = $rentReleaseInsertion;

        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * bin/console {name choosed here} to execute the command
     * @var string
     */
    protected static $defaultName = 'rent:release';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Rent release management')

            // the full command description shown when running the command with the "--help" option
            ->setHelp('This command insert into rent_release table from DB rent value + status AND send an email to
            the lessee to say him \'Hey, you have to pay your rent\' with PDF rent release each month AND
            the owner receive an email too to say him \'Hey, we sent rent release to your lessees, go on 
            gestImmo rent release page to change status from the rent\'')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Rent release',
            '===========================================================================',
            '',
        ]);

        $output->writeln(['Inserting values in database',
            '',
        ]);
        $this->rentReleaseInsertion->settingRentReleaseValues();

        $output->writeln(['Sending email to owner',
            '',
        ]);
        $this->mailer->notifyOwner();
    }
}

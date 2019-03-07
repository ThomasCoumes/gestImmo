<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 07/03/19
 * Time: 14:05
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RentReleaseCommand extends Command
{
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

        //TODO insert values in rentRelease foreach lessee assigned to at least 1 property

        $output->writeln(['Generating PDF',
            '',
        ]);

        //TODO generate PDF from each rent release

        $output->writeln(['Sending emails to lessees',
            '',
        ]);

        //TODO send emails to each lessee assigned to at least 1 property

        $output->writeln(['Sending email to owner',
            '',
        ]);

        //TODO send emails to each owner who as at least 1 lessee assigned to a property
    }
}

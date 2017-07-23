<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AppCheckWinnerCommand
 *
 * @package AppBundle\Command
 */
class AppCheckWinnerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:check-winner')
            ->setDescription('Check Winner for bets.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Bettings')
            ->checkWinner();

        $output->writeln('The winners are defined.');
    }
}

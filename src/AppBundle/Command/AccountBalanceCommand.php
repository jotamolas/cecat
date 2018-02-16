<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AccountBalanceCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cecat:account:balance')
                ->setDescription('Calcula un Balance de una cuenta')
                ->setDefinition([
                    new InputArgument('AccountId', InputArgument::REQUIRED, 'Ingresar el Id de Cuenta')
                ])
                ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $account = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Account')->find($input->getArgument('AccountId'));
        
        if($account){
            $balance = $this->getContainer()->get('account.service')->calculateBalance($account);
        }
        
        
        if($balance){
            $output->writeln(sprintf('El balance de la cuenta es <comment>%s</comment>', $balance));
        }else{
            $output->writeln(sprintf('No se pudo determinar el Balance o Encontrar la cuenta'));
        }
    }

}

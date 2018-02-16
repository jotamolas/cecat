<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RenaperSimpleQueryCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('renaper:simple:query')
                ->setDescription('Crea una Cuenta asociada a un Notario')
                ->setDefinition([
                    new InputArgument('dni', InputArgument::REQUIRED, 'Ingrese DNI'),
                    new InputArgument('sexo', InputArgument::REQUIRED, 'Ingrese ')
                ])
                ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $result = $this->getContainer()->get('action.service')
                ->RenaperSimpleToAdminQuery($input->getArgument('dni'),$input->getArgument('sexo'));
        
        print_r($result);
    }

}

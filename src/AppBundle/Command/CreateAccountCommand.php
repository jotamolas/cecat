<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAccountCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cecat:account:create')
                ->setDescription('Crea una Cuenta asociada a un Notario')
                ->setDefinition([
                    new InputArgument('notaryId', InputArgument::REQUIRED, 'Ingresar el Id de Notario')
                ])
                ->setHelp(<<<'EOT'
El <info>cecat:account:create</info> comando crea una Cuenta para un Notario:
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $result = $this->getContainer()->get('account.service')->createAccountWithoutNotary($input->getArgument('notaryId'));
        if($result){
            $output->writeln(sprintf('Se creo la cuenta  <comment>%s</comment>', $result->getDescription()));
        }else{
            $output->writeln(sprintf('No se pudo crear una cuenta'));
        }
    }

}

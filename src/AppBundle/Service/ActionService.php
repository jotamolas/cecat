<?php

namespace AppBundle\Service;

use AppBundle\Entity\Account;
use AppBundle\Entity\AccountMove;
use AppBundle\Entity\Notary;
use AppBundle\Entity\TransactionType;
use AppBundle\Entity\Service;
use AppBundle\Entity\Transaction;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActionService {

    protected $em;
    protected $container;

    /**
     * 
     * @param EntityManager $em
     * @param ContainerInterface $container
     */
    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->container = $container;
        $this->em = $em;
    }

    public function accreditation(Notary $notary, $qty, \AppBundle\Entity\Person $person) {

        $service = $this->em->getRepository('AppBundle:Service')->find(1);
        $transactiontype = $this->em->getRepository('AppBundle:TransactionType')->find(2);
        
        $result = $this->transaction($service, $qty, $notary, $transactiontype, 'Compra de Credito', $person);
              
        return $result;
    }

    public function RenaperConnection() {
        $client = new \Soapclient('http://renaperws.idear.gov.ar/ws/DATOSCECATAMARCA.php?wsdl', ['exceptions' => true]);
        return $client;
    }

    public function RenaperSimpleQuery($dni, $gender, $notary ) {
        
        $renaper_query = $this->RenaperConnection()->obtenerUltimoEjemplar(['dni' => $dni, 'sexo' => $gender]);
        
        
        if($renaper_query->nroError != 0){
            
            return [
                'error' => true,
                'message' => $renaper_query->descripcionError
            ];
        }
        
        $service = $this->em->getRepository('AppBundle:Service')->find(3);
        $transactiontype = $this->em->getRepository('AppBundle:TransactionType')->find(1);
        
        $result = $this->transaction($service, 1, $notary, $transactiontype, 'Consulta Renaper Simple', $notary);
        
        return [
            'transaction' => $result['transaction'],
            'error' => false,
            'result'=> $renaper_query
        ];
    }
    
    public function RenaperSimpleToAdminQuery($dni, $gender ) {
        $renaper_query = $this->RenaperConnection()->obtenerUltimoEjemplar(['dni' => $dni, 'sexo' => $gender]);
        return ['result' => $renaper_query];
    }

    public function transaction(Service $service, $qty, Notary $notary, TransactionType $transactiontype, $description, \AppBundle\Entity\Person $person) {
        
        $transaction = new \AppBundle\Entity\Transaction();
        
        $transaction->setQty($qty)
                ->setService($service)
                ->setNotary($notary)
                ->setTransactionType($transactiontype)
                ->setUser($person);
                
        $transaction->setAmmount($qty * $service->getPrice());
        
        $this->em->persist($transaction);
        $this->em->flush();
          
        $account_move = $this->moveAccount($transaction, $notary, $description);
        
        return 
        [
            'transaction' => $transaction,
            'account_move' => $account_move 
        ];        
        
    }
    
       
    
    public function moveAccount(Transaction $transaction, Notary $notary, $description){
        
        $account_move = new AccountMove();
        $account_move->setAccount($notary->getAccount())
                ->setDescription($description)
                ->setTransaction($transaction);
        
        if($transaction->getTransactionType()->getId() == 1){
            $account_move->setDebit($transaction->getAmmount());
            $account_move->setCredit(0);
        }else{
            $account_move->setCredit($transaction->getAmmount());
            $account_move->setDebit(0);
        }
       
        
        $this->em->persist($account_move);
        $this->em->flush();

        $balance = $this->container->get('account.service')->calculateBalance($notary->getAccount());
        $notary->getAccount()->setBalance($balance);
        $this->em->flush();
        
        return $account_move;
    }

}

<?php

namespace AppBundle\Service;

use AppBundle\Entity\Account;
use AppBundle\Entity\AccountMove;
use AppBundle\Entity\Notary;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AccountService {

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

    public function createAccount(Notary $notary) {

        $account = new Account;
        $account->setNotary($notary)
                ->setDescription('00001000' . $notary->getIdPerson() . "-" . $notary->getFirstName() . " " . $notary->getLastName())
                ->setBalance(0);

        $this->em->persist($account);
        $this->em->flush();
        
        return $account;
    }
    
    
    public function createAccountWithoutNotary($id){
        $notary = $this->em->getRepository('AppBundle:Notary')->find($id);
        return $this->createAccount($notary) ;
    }
    
    public function calculateBalance(Account $account){
        $moves = $account->getMoves();
        $debit = 0;
        $credit = 0;
        foreach ($moves as $move){            
            if($move->getTransaction()->getTransactionType()->getId() == 1){
                $debit += $move->getDebit();
            }else{
                $credit += $move->getCredit();               
            }          
        }
        
        $balance = $credit - $debit;
        
        return $balance;
    }
}

<?php

namespace AppBundle\Service;

use DataDog\PagerBundle\Pagination;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class PersonService{
    private $em;
    private $container;
    
    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }
    
    
    public function filters(QueryBuilder $qb, $key, $val) {

        switch ($key) {

            case 'p.idPerson':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('p.idPerson', ':idPerson'));
                    $qb->setParameter('idPerson', "%$val%");
                }
                break;

            case 'p.firstName':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('p.firstName', ':firstName'));
                    $qb->setParameter('firstName', "%$val%");
                }
                break;
                
            case 'p.lastName':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('p.lastName', ':lastName'));
                    $qb->setParameter('lastName', "%$val%");
                }
                break;    

            case 'p.username':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('p.username', ':username'));
                    $qb->setParameter('username', "%$val%");
                }
                break;  

            default:

                throw new \Exception("filter not allowed");
        }
    }

    public function pagination(Request $request) {

        $dql = $this->em->getRepository('AppBundle:Person')->createQueryBuilder('p')

        ;
        
        

        $options = [
            'sorters' => ['p.id' => 'ASC'],
            'applyFilter' => [$this, 'filters'],
        ];
        
        

        $paginator = new Pagination($dql, $request, $options);
        
        return [
            "paginator" => $paginator,

        ];
    }
}
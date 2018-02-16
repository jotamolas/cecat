<?php

namespace AppBundle\Service;

use DataDog\PagerBundle\Pagination;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class NotaryService{
    private $em;
    private $container;
    
    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }
    
    
    public function filters(QueryBuilder $qb, $key, $val) {

        switch ($key) {

            case 'n.idPerson':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('n.idPerson', ':idPerson'));
                    $qb->setParameter('idPerson', "%$val%");
                }
                break;

            case 'n.firstName':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('n.firstName', ':firstName'));
                    $qb->setParameter('firstName', "%$val%");
                }
                break;
                
            case 'n.lastName':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('n.lastName', ':lastName'));
                    $qb->setParameter('lastName', "%$val%");
                }
                break;    

            case 'n.username':
                if ($val) {
                    $qb->andWhere($qb->expr()->like('n.username', ':username'));
                    $qb->setParameter('username', "%$val%");
                }
                break;

            case 'r.id':
                if ($val) {
                    $qb->andWhere($qb->expr()->eq('r.id', ':id'));
                    $qb->setParameter('id', $val);
                }
                break;
                
            case 'nt.id':
                if ($val) {
                    $qb->andWhere($qb->expr()->eq('nt.id', ':id'));
                    $qb->setParameter('id', $val);
                }
                break;    

            default:

                throw new \Exception("filter not allowed");
        }
    }

    public function pagination(Request $request) {

        $dql = $this->em->getRepository('AppBundle:Notary')->createQueryBuilder('n')
                ->addSelect('r')
                ->addSelect('nt')
                ->leftJoin('n.registro', 'r')
                ->leftJoin('n.notaryTypeId', 'nt')

        ;
        
        

        $options = [
            'sorters' => ['r.description' => 'ASC'],
            'applyFilter' => [$this, 'filters'],
        ];
        
        $notary_type_options = [Pagination::$filterAny => 'Any'];
        $notray_types = $this->em->getRepository("AppBundle:NotaryType")->findAll();
        foreach ($notray_types as $t) {
            $notary_type_options [$t->getId()] = $t->getDescription();
        }
        
        $regitro_options = [Pagination::$filterAny => 'Any'];
        $registros = $this->em->getRepository("AppBundle:Registro")->findAll();
        foreach ($registros as $r) {
            $regitro_options [$r->getId()] = $r->getDescription();
        }        

        $paginator = new Pagination($dql, $request, $options);
        
        return [
            "paginator" => $paginator,
            "notary_type_options" => $notary_type_options,
            "registro_options" => $regitro_options
        ];
    }
}
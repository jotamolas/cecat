<?php

namespace Openerp\ConnectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

require_once __DIR__ . '/openerp/openerp.class.php';

/**
 * @Route("openerp")
 */
class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('ConnectBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/portada", name="portada")
     * @param Request $request
     * @return type
     */
    public function loginAction(Request $request) {
        $rpc = new \OpenERP();
        $uid = $rpc->login('admin', 'Lived5014', 'qa');
        $name = $rpc->read(array($uid), array('name'), 'res.users');
        return $this->render('ConnectBundle:Default:welcome.html.twig', array(
                    'name' => $name));
    }
    
    /**
     * @Route("/products", name="products")
     * @param Request $request
     * @return type
     */
    public function searchAction(Request $request){
        $rpc = new \OpenERP();
        $uid = $rpc->login('admin', 'Lived5014', 'qa');
        $fields = array('id','name','company','model');
        $ids = range(1000,1500);
        
        $partners  = $rpc->read($ids, $fields, 'res.partner');
        return $this->render('ConnectBundle:Default:welcome.html.twig', array(
                    'name' => $partners));
    }

}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="cecat_index")
     */
    public function indexAction(Request $request)
    {

        
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('cecat_admin_page');
        } elseif ($this->isGranted('ROLE_NOTARIO')) {
            return $this->redirectToRoute('cecat_front_page');
        }
        return $this->redirectToRoute('fos_user_security_login');

    }

    /**
     * @Route("/admin", name="cecat_admin_page")
     */
    public function adminIdexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:admin.html.twig');

    }

    /**
     * @Route("/front", name="cecat_front_page")
     */
    public function frontIndexAction(Request $request)
    {

        return $this->render('AppBundle:Default:front.html.twig');
    }
    
    /**
     * @Route("/accountant", name="cecat_accountant_page")
     */
    public function accountantIndexAction(Request $request)
    {

        return $this->render('AppBundle:Default:accountant.html.twig');
    }

    /**
     * @Route("/test", name="cecat_test")
     * @param \AppBundle\Entity\Account $account
     * @return type
     */
    public function test(){
        dump(in_array('ROLE_ADMIN', $this->getUser()->getRoles()));
        return in_array('ROLE_ADMIN', $this->getUser()->getRoles()); 
    }
           
}

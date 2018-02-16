<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("person")
 */
class PersonController extends Controller {

    /**
     * @Route("/list", name="person_list")
     * @return type
     * 
     */
    public function listAction(Request $request) {

        $persons = $this->get('person.service')->pagination($request);
        
        $this->denyAccessUnlessGranted('view',$persons['paginator'][0] );
        $options = [
            'persons' => $persons['paginator'],
        ];

        return $this->render('AppBundle:Person:list.html.twig', $options);
    }

    /**
     * 
     * @Route("/change/password/{person}", name="person_change_password")     
     * @param \AppBundle\Entity\Person $person
     * @param Request $request
     * @return type
     * @Security("is_granted('change_password', person)")
     */
    public function changePassword(\AppBundle\Entity\Person $person, Request $request) {


        $form = $this->createForm(\AppBundle\Form\PersonPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $manipulator = $this->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($person->getUsername(), $data['password']);
            $this->addFlash('notice', 'Se cambio la contraseña de usuario: '. $person->getUsername() );
            return $this->redirect($request->headers->get('referer'));
        }


        return $this->render('AppBundle:Person:change.password.html.twig', [
                    'form' => $form->createView()
        ]);
    }
    
    
    
    
    /**
     * @Route("/admin/activate/user/{person}", name="person_activate_user")  
     * @param \AppBundle\Entity\Person $person
     */
    public function activateAction(\AppBundle\Entity\Person $person){
         $manipulator = $this->get('fos_user.util.user_manipulator');
         $manipulator->activate($person->getUsername());
         $this->addFlash('notice', 'Se activo el usuario'. $person->getUsername() );
         return $this->redirectToRoute('person_list');
    }
}

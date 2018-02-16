<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Notary;

/**
 * @Route("notary")
 */
class NotaryController extends Controller {

    /**
     * @Route("/new", name="notary_new")
     * @return type
     * @Method({"POST","GET"})
     * 
     */
    public function newAction(Request $request) {

        $notary = new \AppBundle\Entity\Notary();
        $this->denyAccessUnlessGranted('create', $notary);
        $form = $this->createForm(\AppBundle\Form\NotaryRegistrationType::class, $notary);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notary->addRole('ROLE_NOTARIO');
            $notary->setEnabled(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($notary);
            $em->flush();

            $this->get('account.service')->createAccount($notary);

            return $this->redirectToRoute('notary_list');
        }

        return $this->render('AppBundle:Notary:new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing account entity.
     *
     * @Route("/{id}/edit", name="notary_edit")
     * @Method({"GET", "POST"})
     * 
     */
    public function editAction(Request $request, \AppBundle\Entity\Notary $notary) {
        $this->denyAccessUnlessGranted('edit', $notary);
        $editForm = $this->createForm(\AppBundle\Form\NotaryRegistrationType::class, $notary);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notary_list');
        }

        return $this->render('AppBundle:Notary:edit.html.twig', array(
                    'notary' => $notary,
                    'form_edit' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/list", name="notary_list")
     * @return type
     */
    public function listAction(Request $request) {

        $notaries = $this->get('notary.service')->pagination($request);
        $this->denyAccessUnlessGranted('list', $notaries['paginator'][0]);
        $options = [
            'notaries' => $notaries['paginator'],
            'notary_type_options' => $notaries['notary_type_options'],
            'registro_options' => $notaries['registro_options']
        ];

        return $this->render('AppBundle:Notary:list.html.twig', $options);
    }

    //

    /**
     * @Route("/balance/{notario}", name="notary_balance")
     * @param \AppBundle\Entity\Notary $notario
     */
    public function getAccountBalanceAction(\AppBundle\Entity\Notary $notario) {
        print $this->get('account.service')->calculateBalance($notario->getAccount());
    }

}

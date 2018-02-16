<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Account controller.
 *
 * @Route("account")
 */
class AccountController extends Controller
{
    /**
     * Lists all account entities.
     *
     * @Route("/", name="account_index")
     * @Method("GET")
     * @Security("is_granted('view', account)")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accounts = $em->getRepository('AppBundle:Account')->findAll();

        return $this->render('account/index.html.twig', array(
            'accounts' => $accounts,
        ));
    }

    /**
     * Creates a new account entity.
     *
     * @Route("/new", name="account_new")
     * @Method({"GET", "POST"})
     * 
     * @Security("is_granted('create', account)")
     */
    public function newAction(Request $request)
    {
        $account = new Account();
        $form = $this->createForm('AppBundle\Form\AccountType', $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            return $this->redirectToRoute('account_show', array('id' => $account->getId()));
        }

        return $this->render('account/new.html.twig', array(
            'account' => $account,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a account entity.
     *
     * @Route("/{id}", name="account_show")
     * @Method("GET")
     * 
     */
    public function showAction(Account $account)
    {
        
         
        $deleteForm = $this->createDeleteForm($account);
        $this->denyAccessUnlessGranted('view', $account);
        return $this->render('AppBundle:Account:show.html.twig', array(
            'account' => $account,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing account entity.
     *
     * @Route("/admin/{id}/edit", name="account_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', account)")
     */
    public function editAction(Request $request, Account $account)
    {
        
        $deleteForm = $this->createDeleteForm($account);
        $editForm = $this->createForm('AppBundle\Form\AccountType', $account);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_list');
        }

        return $this->render('AppBundle:Account:edit.html.twig', array(
            'account' => $account,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a account entity.
     *
     * @Route("/{id}", name="account_delete")
     * @Method("DELETE")
     * @Security("is_granted('delete', account)")
     */
    public function deleteAction(Request $request, Account $account)
    {
        $form = $this->createDeleteForm($account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($account);
            $em->flush();
        }

        return $this->redirectToRoute('account_index');
    }

    /**
     * Creates a form to delete a account entity.
     *
     * @param Account $account The account entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Account $account)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_delete', array('id' => $account->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    /**
     * @Route("/ledger/{id}", name="account_ledger")
     * @param Account $account
     * @Security("is_granted('view', account)")
     */
    public function showLedgerAction(Request $request,Account $account){
        
        $moves = $account->getMoves();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $moves, /* query NOT result */ 
                $request->query->getInt('page', 1)/* page number */,
                10);
        
        return $this->render('AppBundle:Account:ledger.html.twig', [
            'moves' => $pagination,
            'account' => $account
        ]);     
        
    }
    
    
    
}

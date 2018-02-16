<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Transactiontype controller.
 *
 * @Route("transactiontype")
 */
class TransactionTypeController extends Controller
{
    /**
     * Lists all transactionType entities.
     *
     * @Route("/", name="transactiontype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactionTypes = $em->getRepository('AppBundle:TransactionType')->findAll();

        return $this->render('transactiontype/index.html.twig', array(
            'transactionTypes' => $transactionTypes,
        ));
    }

    /**
     * Creates a new transactionType entity.
     *
     * @Route("/new", name="transactiontype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $transactionType = new Transactiontype();
        $form = $this->createForm('AppBundle\Form\TransactionTypeType', $transactionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transactionType);
            $em->flush();

            return $this->redirectToRoute('transactiontype_show', array('id' => $transactionType->getId()));
        }

        return $this->render('transactiontype/new.html.twig', array(
            'transactionType' => $transactionType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transactionType entity.
     *
     * @Route("/{id}", name="transactiontype_show")
     * @Method("GET")
     */
    public function showAction(TransactionType $transactionType)
    {
        $deleteForm = $this->createDeleteForm($transactionType);

        return $this->render('transactiontype/show.html.twig', array(
            'transactionType' => $transactionType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transactionType entity.
     *
     * @Route("/{id}/edit", name="transactiontype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TransactionType $transactionType)
    {
        $deleteForm = $this->createDeleteForm($transactionType);
        $editForm = $this->createForm('AppBundle\Form\TransactionTypeType', $transactionType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transactiontype_edit', array('id' => $transactionType->getId()));
        }

        return $this->render('transactiontype/edit.html.twig', array(
            'transactionType' => $transactionType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transactionType entity.
     *
     * @Route("/{id}", name="transactiontype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TransactionType $transactionType)
    {
        $form = $this->createDeleteForm($transactionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transactionType);
            $em->flush();
        }

        return $this->redirectToRoute('transactiontype_index');
    }

    /**
     * Creates a form to delete a transactionType entity.
     *
     * @param TransactionType $transactionType The transactionType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TransactionType $transactionType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transactiontype_delete', array('id' => $transactionType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\NotaryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Notarytype controller.
 *
 * @Route("notarytype")
 */
class NotaryTypeController extends Controller
{
    /**
     * Lists all notaryType entities.
     *
     * @Route("/", name="notarytype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notaryTypes = $em->getRepository('AppBundle:NotaryType')->findAll();

        return $this->render('notarytype/index.html.twig', array(
            'notaryTypes' => $notaryTypes,
        ));
    }

    /**
     * Creates a new notaryType entity.
     *
     * @Route("/new", name="notarytype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notaryType = new Notarytype();
        $form = $this->createForm('AppBundle\Form\NotaryTypeType', $notaryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notaryType);
            $em->flush();

            return $this->redirectToRoute('notarytype_show', array('id' => $notaryType->getId()));
        }

        return $this->render('notarytype/new.html.twig', array(
            'notaryType' => $notaryType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notaryType entity.
     *
     * @Route("/{id}", name="notarytype_show")
     * @Method("GET")
     */
    public function showAction(NotaryType $notaryType)
    {
        $deleteForm = $this->createDeleteForm($notaryType);

        return $this->render('notarytype/show.html.twig', array(
            'notaryType' => $notaryType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notaryType entity.
     *
     * @Route("/{id}/edit", name="notarytype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, NotaryType $notaryType)
    {
        $deleteForm = $this->createDeleteForm($notaryType);
        $editForm = $this->createForm('AppBundle\Form\NotaryTypeType', $notaryType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notarytype_edit', array('id' => $notaryType->getId()));
        }

        return $this->render('notarytype/edit.html.twig', array(
            'notaryType' => $notaryType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notaryType entity.
     *
     * @Route("/{id}", name="notarytype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, NotaryType $notaryType)
    {
        $form = $this->createDeleteForm($notaryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notaryType);
            $em->flush();
        }

        return $this->redirectToRoute('notarytype_index');
    }

    /**
     * Creates a form to delete a notaryType entity.
     *
     * @param NotaryType $notaryType The notaryType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NotaryType $notaryType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notarytype_delete', array('id' => $notaryType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

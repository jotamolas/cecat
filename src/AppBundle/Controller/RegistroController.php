<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("registro")
 */
class RegistroController extends Controller {

    /**
     * @Route("/new", name="registro_new")
     * @return type
     * @Method({"POST","GET"})
     */
    public function newAction(Request $request) {

        $registro = new \AppBundle\Entity\Registro();
        $form = $this->createForm(\AppBundle\Form\RegistroType::class, $registro);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $registro->setDescription();
            $em = $this->getDoctrine()->getManager();
            $em->persist($registro);
            $em->flush();
            return $this->redirectToRoute('registro_list');
        }

        return $this->render('AppBundle:Registro:new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing account entity.
     *
     * @Route("/{id}/edit", name="registro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, \AppBundle\Entity\Registro $registro) {

        $editForm = $this->createForm(\AppBundle\Form\RegistroType::class, $registro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registro_list');
        }

        return $this->render('AppBundle:Registro:edit.html.twig', array(
                    'registro' => $registro,
                    'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/list", name="registro_list")
     * @param Request $request
     * @return type
     */
    public function listAction(Request $request) {

        $registros = $this->getDoctrine()->getRepository('AppBundle:Registro')->findAll();
        return $this->render('AppBundle:Registro:list.html.twig', [
                    'registros' => $registros
        ]);
    }

}

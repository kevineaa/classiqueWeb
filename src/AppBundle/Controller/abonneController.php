<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Abonne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Abonne controller.
 *
 * @Route("abonne")
 */
class abonneController extends Controller
{
    /**
     * Lists all abonne entities.
     *
     * @Route("/", name="abonne_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abonnes = $em->getRepository('AppBundle:abonne')->findAll();

        return $this->render('abonne/index.html.twig', array(
            'abonnes' => $abonnes,
        ));
    }

    /**
     * Creates a new abonne entity.
     *
     * @Route("/new", name="abonne_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $abonne = new Abonne();
        $form = $this->createForm('AppBundle\Form\abonneType', $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abonne);
            $em->flush();

            return $this->redirectToRoute('abonne_show', array('codeAbonne' => $abonne->getCodeabonne()));
        }

        return $this->render('abonne/new.html.twig', array(
            'abonne' => $abonne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abonne entity.
     *
     * @Route("/{codeAbonne}", name="abonne_show")
     * @Method("GET")
     */
    public function showAction(abonne $abonne)
    {
        $deleteForm = $this->createDeleteForm($abonne);

        return $this->render('abonne/show.html.twig', array(
            'abonne' => $abonne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing abonne entity.
     *
     * @Route("/{codeAbonne}/edit", name="abonne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, abonne $abonne)
    {
        $deleteForm = $this->createDeleteForm($abonne);
        $editForm = $this->createForm('AppBundle\Form\abonneType', $abonne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonne_edit', array('codeAbonne' => $abonne->getCodeabonne()));
        }

        return $this->render('abonne/edit.html.twig', array(
            'abonne' => $abonne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a abonne entity.
     *
     * @Route("/{codeAbonne}", name="abonne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, abonne $abonne)
    {
        $form = $this->createDeleteForm($abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonne);
            $em->flush();
        }

        return $this->redirectToRoute('abonne_index');
    }

    /**
     * Creates a form to delete a abonne entity.
     *
     * @param abonne $abonne The abonne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(abonne $abonne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonne_delete', array('codeAbonne' => $abonne->getCodeabonne())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

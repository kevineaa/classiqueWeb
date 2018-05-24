<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Musicien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Musicien controller.
 *
 * @Route("musicien")
 */
class MusicienController extends Controller
{
    /**
     * Lists all musicien entities.
     *
     * @Route("/", name="musicien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

     //   $musiciens = $em->getRepository('AppBundle:Musicien')->findAll();
$musiciens = $em->getRepository('AppBundle:Musicien')->findBy([], [], 10);

        return $this->render('musicien/index.html.twig', array(
            'musiciens' => $musiciens,
        ));
    }

    /**
     * Creates a new musicien entity.
     *
     * @Route("/new", name="musicien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $musicien = new Musicien();
        $form = $this->createForm('AppBundle\Form\MusicienType', $musicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($musicien);
            $em->flush();

            return $this->redirectToRoute('musicien_show', array('codeMusicien' => $musicien->getCodemusicien()));
        }

        return $this->render('musicien/new.html.twig', array(
            'musicien' => $musicien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a musicien entity.
     *
     * @Route("/{codeMusicien}", name="musicien_show")
     * @Method("GET")
     */
    public function showAction(Musicien $musicien)
    {
        $deleteForm = $this->createDeleteForm($musicien);

        return $this->render('musicien/show.html.twig', array(
            'musicien' => $musicien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing musicien entity.
     *
     * @Route("/{codeMusicien}/edit", name="musicien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Musicien $musicien)
    {
        $deleteForm = $this->createDeleteForm($musicien);
        $editForm = $this->createForm('AppBundle\Form\MusicienType', $musicien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('musicien_edit', array('codeMusicien' => $musicien->getCodemusicien()));
        }

        return $this->render('musicien/edit.html.twig', array(
            'musicien' => $musicien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a musicien entity.
     *
     * @Route("/{codeMusicien}", name="musicien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Musicien $musicien)
    {
        $form = $this->createDeleteForm($musicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($musicien);
            $em->flush();
        }

        return $this->redirectToRoute('musicien_index');
    }

    /**
     * Creates a form to delete a musicien entity.
     *
     * @param Musicien $musicien The musicien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Musicien $musicien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('musicien_delete', array('codeMusicien' => $musicien->getCodemusicien())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\phdStudent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Phdstudent controller.
 *
 * @Route("phdstudent")
 */
class phdStudentController extends Controller
{
    /**
     * Lists all phdStudent entities.
     *
     * @Route("/", name="phdstudent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $phdStudents = $em->getRepository('AppBundle:phdStudent')->findAll();

        return $this->render('phdstudent/index.html.twig', array(
            'phdStudents' => $phdStudents,
        ));
    }

    /**
     * Creates a new phdStudent entity.
     *
     * @Route("/new", name="phdstudent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $phdStudent = new Phdstudent();
        $form = $this->createForm('AppBundle\Form\phdStudentType', $phdStudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phdStudent);
            $em->flush($phdStudent);

            return $this->redirectToRoute('phdstudent_show', array('id' => $phdStudent->getId()));
        }

        return $this->render('phdstudent/new.html.twig', array(
            'phdStudent' => $phdStudent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a phdStudent entity.
     *
     * @Route("/{id}", name="phdstudent_show")
     * @Method("GET")
     */
    public function showAction(phdStudent $phdStudent)
    {
        $deleteForm = $this->createDeleteForm($phdStudent);

        return $this->render('phdstudent/show.html.twig', array(
            'phdStudent' => $phdStudent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing phdStudent entity.
     *
     * @Route("/{id}/edit", name="phdstudent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, phdStudent $phdStudent)
    {
        $deleteForm = $this->createDeleteForm($phdStudent);
        $editForm = $this->createForm('AppBundle\Form\phdStudentType', $phdStudent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phdstudent_edit', array('id' => $phdStudent->getId()));
        }

        return $this->render('phdstudent/edit.html.twig', array(
            'phdStudent' => $phdStudent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a phdStudent entity.
     *
     * @Route("/{id}", name="phdstudent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, phdStudent $phdStudent)
    {
        $form = $this->createDeleteForm($phdStudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phdStudent);
            $em->flush($phdStudent);
        }

        return $this->redirectToRoute('phdstudent_index');
    }

    /**
     * Creates a form to delete a phdStudent entity.
     *
     * @param phdStudent $phdStudent The phdStudent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(phdStudent $phdStudent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phdstudent_delete', array('id' => $phdStudent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

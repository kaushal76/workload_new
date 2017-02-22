<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PhdStudent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Phdstudent controller.
 *
 * @Route("phdstudent")
 */
class PhdStudentController extends Controller
{
    /**
     * Lists all PhdStudent entities.
     *
     * @Route("/", name="phdstudent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $phdStudents = $em->getRepository('AppBundle:PhdStudent')->findAll();

        return $this->render('phdstudent/index.html.twig', array(
            'phdStudents' => $phdStudents,
        ));
    }

    /**
     * Creates a new PhdStudent entity.
     *
     * @Route("/new", name="phdstudent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $phdStudent = new PhdStudent;

        $form = $this->createForm('AppBundle\Form\PhdStudentType', $phdStudent);
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
     * Finds and displays a PhdStudent entity.
     *
     * @Route("/{id}", name="phdstudent_show")
     * @Method("GET")
     */
    public function showAction(PhdStudent $phdStudent)
    {
        $deleteForm = $this->createDeleteForm($phdStudent);

        return $this->render('phdstudent/show.html.twig', array(
            'phdStudent' => $phdStudent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PhdStudent entity.
     *
     * @Route("/{id}/edit", name="phdstudent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PhdStudent $phdStudent)
    {
        $deleteForm = $this->createDeleteForm($phdStudent);
        $editForm = $this->createForm('AppBundle\Form\PhdStudentType', $phdStudent);
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
     * Deletes a PhdStudent entity.
     *
     * @Route("/{id}", name="phdstudent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PhdStudent $phdStudent)
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
     * Creates a form to delete a PhdStudent entity.
     *
     * @param PhdStudent $phdStudent The PhdStudent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PhdStudent $phdStudent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phdstudent_delete', array('id' => $phdStudent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to show an existing Module entity.
     *
     * @param Request $request Module $module
     * @Route("/{id}/allocate", name="phdstudent_allocate")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function allocationsAction(Request $request, PhdStudent $phdStudent)
    {

        $form = $this->createForm('AppBundle\Form\PhdStudentType', $phdStudent);
        $em = $this->getDoctrine()->getManager();
        $phdStudentObj = $em->getRepository('AppBundle:PhdStudent')->find($phdStudent);

        $originalAllocationsforPhdStudent = new ArrayCollection();

        foreach ($phdStudentObj->getAllocationsForPhDStudent() as $allocationForPhdStudent) {
            $originalAllocationsforPhdStudent->add($allocationForPhdStudent);
        }

        //$total = $this->calculateTotals($item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            foreach ($phdStudent->getAllocationsForPhDStudent() as $allocationsForPhDStudent) {
                $allocationsForPhDStudent->setPhdStudent($phdStudent);
                $allocationsForPhDStudent->setSupportHrs( $allocationsForPhDStudent->getAllocatedHrs());
            }

            foreach ($originalAllocationsforPhdStudent as $allocationsForPhDStudent) {
                if (false === $phdStudent->getAllocationsForPhDStudent()->contains($allocationsForPhDStudent)) {
                    $em->remove($allocationsForPhDStudent);
                }
            }
            $em->persist($phdStudent);
            $em->flush();
            return $this->redirectToRoute('phdstudent_allocate', array('id' => $phdStudent->getId()));

        }

        return $this->render(':phdstudent:allocate.html.twig', array(
            'phdStudent' => $phdStudent,
            'form' => $form->createView(),
        ));

    }
}

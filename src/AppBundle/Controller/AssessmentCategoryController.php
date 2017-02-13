<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AssessmentCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Assessmentcategory controller.
 *
 * @Route("assessmentcategory")
 */
class AssessmentCategoryController extends Controller
{
    /**
     * Lists all assessmentCategory entities.
     *
     * @Route("/", name="assessmentcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $assessmentCategories = $em->getRepository('AppBundle:AssessmentCategory')->findAll();

        return $this->render('assessmentcategory/index.html.twig', array(
            'assessmentCategories' => $assessmentCategories,
        ));
    }

    /**
     * Creates a new assessmentCategory entity.
     *
     * @Route("/new", name="assessmentcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $assessmentCategory = new Assessmentcategory();
        $form = $this->createForm('AppBundle\Form\AssessmentCategoryType', $assessmentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assessmentCategory);
            $em->flush($assessmentCategory);

            return $this->redirectToRoute('assessmentcategory_show', array('id' => $assessmentCategory->getId()));
        }

        return $this->render('assessmentcategory/new.html.twig', array(
            'assessmentCategory' => $assessmentCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a assessmentCategory entity.
     *
     * @Route("/{id}", name="assessmentcategory_show")
     * @Method("GET")
     */
    public function showAction(AssessmentCategory $assessmentCategory)
    {
        $deleteForm = $this->createDeleteForm($assessmentCategory);

        return $this->render('assessmentcategory/show.html.twig', array(
            'assessmentCategory' => $assessmentCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing assessmentCategory entity.
     *
     * @Route("/{id}/edit", name="assessmentcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AssessmentCategory $assessmentCategory)
    {
        $deleteForm = $this->createDeleteForm($assessmentCategory);
        $editForm = $this->createForm('AppBundle\Form\AssessmentCategoryType', $assessmentCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('assessmentcategory_edit', array('id' => $assessmentCategory->getId()));
        }

        return $this->render('assessmentcategory/edit.html.twig', array(
            'assessmentCategory' => $assessmentCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a assessmentCategory entity.
     *
     * @Route("/{id}", name="assessmentcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AssessmentCategory $assessmentCategory)
    {
        $form = $this->createDeleteForm($assessmentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($assessmentCategory);
            $em->flush($assessmentCategory);
        }

        return $this->redirectToRoute('assessmentcategory_index');
    }

    /**
     * Creates a form to delete a assessmentCategory entity.
     *
     * @param AssessmentCategory $assessmentCategory The assessmentCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AssessmentCategory $assessmentCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('assessmentcategory_delete', array('id' => $assessmentCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

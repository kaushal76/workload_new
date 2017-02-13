<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PreparationCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Preparationcategory controller.
 *
 * @Route("preparationcategory")
 */
class PreparationCategoryController extends Controller
{
    /**
     * Lists all preparationCategory entities.
     *
     * @Route("/", name="preparationcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $preparationCategories = $em->getRepository('AppBundle:PreparationCategory')->findAll();

        return $this->render('preparationcategory/index.html.twig', array(
            'preparationCategories' => $preparationCategories,
        ));
    }

    /**
     * Creates a new preparationCategory entity.
     *
     * @Route("/new", name="preparationcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $preparationCategory = new Preparationcategory();
        $form = $this->createForm('AppBundle\Form\PreparationCategoryType', $preparationCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preparationCategory);
            $em->flush($preparationCategory);

            return $this->redirectToRoute('preparationcategory_show', array('id' => $preparationCategory->getId()));
        }

        return $this->render('preparationcategory/new.html.twig', array(
            'preparationCategory' => $preparationCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a preparationCategory entity.
     *
     * @Route("/{id}", name="preparationcategory_show")
     * @Method("GET")
     */
    public function showAction(PreparationCategory $preparationCategory)
    {
        $deleteForm = $this->createDeleteForm($preparationCategory);

        return $this->render('preparationcategory/show.html.twig', array(
            'preparationCategory' => $preparationCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing preparationCategory entity.
     *
     * @Route("/{id}/edit", name="preparationcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PreparationCategory $preparationCategory)
    {
        $deleteForm = $this->createDeleteForm($preparationCategory);
        $editForm = $this->createForm('AppBundle\Form\PreparationCategoryType', $preparationCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('preparationcategory_edit', array('id' => $preparationCategory->getId()));
        }

        return $this->render('preparationcategory/edit.html.twig', array(
            'preparationCategory' => $preparationCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a preparationCategory entity.
     *
     * @Route("/{id}", name="preparationcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PreparationCategory $preparationCategory)
    {
        $form = $this->createDeleteForm($preparationCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($preparationCategory);
            $em->flush($preparationCategory);
        }

        return $this->redirectToRoute('preparationcategory_index');
    }

    /**
     * Creates a form to delete a preparationCategory entity.
     *
     * @param PreparationCategory $preparationCategory The preparationCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PreparationCategory $preparationCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('preparationcategory_delete', array('id' => $preparationCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

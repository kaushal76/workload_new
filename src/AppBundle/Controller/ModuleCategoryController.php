<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ModuleCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Modulecategory controller.
 *
 * @Route("modulecategory")
 */
class ModuleCategoryController extends Controller
{
    /**
     * Lists all moduleCategory entities.
     *
     * @Route("/", name="modulecategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $moduleCategories = $em->getRepository('AppBundle:ModuleCategory')->findAll();

        return $this->render('modulecategory/index.html.twig', array(
            'moduleCategories' => $moduleCategories,
        ));
    }

    /**
     * Creates a new moduleCategory entity.
     *
     * @Route("/new", name="modulecategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $moduleCategory = new Modulecategory();
        $form = $this->createForm('AppBundle\Form\ModuleCategoryType', $moduleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($moduleCategory);
            $em->flush($moduleCategory);

            return $this->redirectToRoute('modulecategory_show', array('id' => $moduleCategory->getId()));
        }

        return $this->render('modulecategory/new.html.twig', array(
            'moduleCategory' => $moduleCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a moduleCategory entity.
     *
     * @Route("/{id}", name="modulecategory_show")
     * @Method("GET")
     */
    public function showAction(ModuleCategory $moduleCategory)
    {
        $deleteForm = $this->createDeleteForm($moduleCategory);

        return $this->render('modulecategory/show.html.twig', array(
            'moduleCategory' => $moduleCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing moduleCategory entity.
     *
     * @Route("/{id}/edit", name="modulecategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ModuleCategory $moduleCategory)
    {
        $deleteForm = $this->createDeleteForm($moduleCategory);
        $editForm = $this->createForm('AppBundle\Form\ModuleCategoryType', $moduleCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modulecategory_edit', array('id' => $moduleCategory->getId()));
        }

        return $this->render('modulecategory/edit.html.twig', array(
            'moduleCategory' => $moduleCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a moduleCategory entity.
     *
     * @Route("/{id}", name="modulecategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ModuleCategory $moduleCategory)
    {
        $form = $this->createDeleteForm($moduleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($moduleCategory);
            $em->flush($moduleCategory);
        }

        return $this->redirectToRoute('modulecategory_index');
    }

    /**
     * Creates a form to delete a moduleCategory entity.
     *
     * @param ModuleCategory $moduleCategory The moduleCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ModuleCategory $moduleCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modulecategory_delete', array('id' => $moduleCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

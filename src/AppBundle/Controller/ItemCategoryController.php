<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ItemCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Itemcategory controller.
 *
 * @Route("itemcategory")
 */
class ItemCategoryController extends Controller
{
    /**
     * Lists all itemCategory entities.
     *
     * @Route("/", name="itemcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $itemCategories = $em->getRepository('AppBundle:ItemCategory')->findAll();

        return $this->render('itemcategory/index.html.twig', array(
            'itemCategories' => $itemCategories,
        ));
    }

    /**
     * Creates a new itemCategory entity.
     *
     * @Route("/new", name="itemcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $itemCategory = new Itemcategory();
        $form = $this->createForm('AppBundle\Form\ItemCategoryType', $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($itemCategory);
            $em->flush($itemCategory);

            return $this->redirectToRoute('itemcategory_show', array('id' => $itemCategory->getId()));
        }

        return $this->render('itemcategory/new.html.twig', array(
            'itemCategory' => $itemCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a itemCategory entity.
     *
     * @Route("/{id}", name="itemcategory_show")
     * @Method("GET")
     */
    public function showAction(ItemCategory $itemCategory)
    {
        $deleteForm = $this->createDeleteForm($itemCategory);

        return $this->render('itemcategory/show.html.twig', array(
            'itemCategory' => $itemCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing itemCategory entity.
     *
     * @Route("/{id}/edit", name="itemcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ItemCategory $itemCategory)
    {
        $deleteForm = $this->createDeleteForm($itemCategory);
        $editForm = $this->createForm('AppBundle\Form\ItemCategoryType', $itemCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('itemcategory_edit', array('id' => $itemCategory->getId()));
        }

        return $this->render('itemcategory/edit.html.twig', array(
            'itemCategory' => $itemCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a itemCategory entity.
     *
     * @Route("/{id}", name="itemcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ItemCategory $itemCategory)
    {
        $form = $this->createDeleteForm($itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($itemCategory);
            $em->flush($itemCategory);
        }

        return $this->redirectToRoute('itemcategory_index');
    }

    /**
     * Creates a form to delete a itemCategory entity.
     *
     * @param ItemCategory $itemCategory The itemCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ItemCategory $itemCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('itemcategory_delete', array('id' => $itemCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GroupFilter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Groupfilter controller.
 *
 * @Route("groupfilter")
 */
class GroupFilterController extends Controller
{
    /**
     * Lists all groupFilter entities.
     *
     * @Route("/", name="groupfilter_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupFilters = $em->getRepository('AppBundle:GroupFilter')->findAll();

        return $this->render('groupfilter/index.html.twig', array(
            'groupFilters' => $groupFilters,
        ));
    }

    /**
     * Creates a new groupFilter entity.
     *
     * @Route("/new", name="groupfilter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $groupFilter = new Groupfilter();
        $form = $this->createForm('AppBundle\Form\GroupFilterType', $groupFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupFilter);
            $em->flush($groupFilter);

            return $this->redirectToRoute('groupfilter_show', array('id' => $groupFilter->getId()));
        }

        return $this->render('groupfilter/new.html.twig', array(
            'groupFilter' => $groupFilter,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a groupFilter entity.
     *
     * @Route("/{id}", name="groupfilter_show")
     * @Method("GET")
     */
    public function showAction(GroupFilter $groupFilter)
    {
        $deleteForm = $this->createDeleteForm($groupFilter);

        return $this->render('groupfilter/show.html.twig', array(
            'groupFilter' => $groupFilter,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groupFilter entity.
     *
     * @Route("/{id}/edit", name="groupfilter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GroupFilter $groupFilter)
    {
        $deleteForm = $this->createDeleteForm($groupFilter);
        $editForm = $this->createForm('AppBundle\Form\GroupFilterType', $groupFilter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupfilter_edit', array('id' => $groupFilter->getId()));
        }

        return $this->render('groupfilter/edit.html.twig', array(
            'groupFilter' => $groupFilter,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a groupFilter entity.
     *
     * @Route("/{id}", name="groupfilter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GroupFilter $groupFilter)
    {
        $form = $this->createDeleteForm($groupFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($groupFilter);
            $em->flush($groupFilter);
        }

        return $this->redirectToRoute('groupfilter_index');
    }

    /**
     * Creates a form to delete a groupFilter entity.
     *
     * @param GroupFilter $groupFilter The groupFilter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GroupFilter $groupFilter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupfilter_delete', array('id' => $groupFilter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

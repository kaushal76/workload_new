<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class ItemController
 * @package AppBundle\Controller
 * @Route("item")
 */
class ItemController extends Controller
{
    /**
     * Lists all Item entities.
     *
     * @Route("/", name="item_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AppBundle:Item')->findAll();

        return $this->render(':item:index.html.twig', array(
            'items' => $items,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name = "item_new")
     */

    public function newAction(Request $request)
    {
        $item = new Item;

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('item_index', array('id' => $item->getId()));
        }

        return $this->render(':item:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Item entity.
     *
     * @param Request $request Item $item
     * @Route("/{id}/edit", name="item_edit")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);
        $editForm = $this->createForm(ItemType::class, $item);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            return $this->redirectToRoute('item_edit', array('id' => $item->getId()));
        }
        return $this->render('item/edit.html.twig', array(
            'item' => $item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to show an existing Item entity.
     *
     * @param Request $request Item $item
     * @Route("/{id}/show", name="item_show")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction(Request $request, Item $item)
    {

        $form = $this->createForm(ItemType::class, $item);
        $em = $this->getDoctrine()->getManager();
        $itemObj = $em->getRepository('AppBundle:Item')->find($item);

        $originalAllocations = new ArrayCollection();

        foreach ($itemObj->getAllocations() as $allocation) {
            $originalAllocations->add($allocation);
        }

        $total = $this->calculateTotals($item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($item->getAllocations() as $allocation) {
                $allocation->setItem($item);
                $allocation->setprepHrs($allocation->calculatePrepHrs($item));
                $allocation->setAssessmentHrs($allocation->calculateAssessmentHrs($item));
            }

            foreach ($originalAllocations as $allocation) {
                if (false === $item->getAllocations()->contains($allocation)) {
                    $em->remove($allocation);
                }
            }
            $em->persist($item);
            $em->flush();
            return $this->redirectToRoute('item_show', array('id' => $item->getId()));
        }

        return $this->render('item/show.html.twig', array(
            'item' => $item,
            'form' => $form->createView(),
            'total' => $total,
        ));

    }

    public function calculateTotals(Item $item)
    {
        $totalprepHrs = 0;
        $totalassessmentHrs = 0;
        $totalAllocatedHrs = 0;
        $prepHrsBalance =0;
        $assessmentBalance=0;
        $contactBalance=0;

        $module = $item->getModule();
        if (is_object($module))
        {

            $modulePrepHrs = $module->getPreparationHrs();
            $moduleAssessmentHrs = $module->getAssessmentHrs();
            $moduleContactHrs = $module->getContactHrs();

            foreach ($item->getAllocations() as $allocation) {
                $totalprepHrs +=(float)$allocation->calculatePrepHrs($item);
                $totalassessmentHrs +=(float)$allocation->calculateAssessmentHrs($item);
                $totalAllocatedHrs +=(float)$allocation->getAllocatedHrs();
            }

            $prepHrsBalance = (float)$modulePrepHrs - (float)$totalprepHrs;
            $assessmentBalance = (float)$moduleAssessmentHrs - (float)$totalassessmentHrs;
            $contactBalance = (float)$moduleContactHrs - (float)$totalAllocatedHrs;

        }

        return array (
            'totalPrepHrs'=> $totalprepHrs,
            'totalAssessmentHrs' =>$totalassessmentHrs,
            'totalAllocatedHrs' =>$totalAllocatedHrs,
            'prepHrsBalance' => $prepHrsBalance,
            'assessmentHrsBalance' =>$assessmentBalance,
            'contactHrsBalance' =>$contactBalance,
        );
    }

    /**
     * Deletes an item entity.
     *
     * @Route("/{id}", name="item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Item $item)
    {
        $form = $this->createDeleteForm($item);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }
        return $this->redirectToRoute('item_index');
    }

    /**
     * Creates a form to delete a item entity
     * @param Item $item The Item entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Item $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
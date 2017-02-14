<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Staff;
use AppBundle\Form\StaffType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class StaffController
 * @package AppBundle\Controller
 * @Route("staff")
 */
class StaffController extends Controller
{
    /**
     * Lists all Staff entities.
     *
     * @Route("/", name="index_staff")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $staffs = $em->getRepository('AppBundle:Staff')->findAll();

        return $this->render(':staff:index.html.twig', array(
            'staffs' => $staffs,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name = "new_staff")
     */

    public function newAction(Request $request)
    {
        $staff = new Staff;

        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();

            return $this->redirectToRoute('homepage', array('id' => $staff->getId()));
        }

        return $this->render(':staff:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Staff entity.
     *
     * @param Request $request Staff $staff
     * @Route("/{id}/edit", name="edit_staff")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Staff $staff)
    {
        $deleteForm = $this->createDeleteForm($staff);
        $editForm = $this->createForm(StaffType::class, $staff);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('edit_staff', array('id' => $staff->getId()));
        }
        return $this->render('staff/edit.html.twig', array(
            'staff' => $staff,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to show an existing Staff entity.
     *
     * @param Request $request Staff $staff
     * @Route("/{id}/show", name="show_staff")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction(Request $request, Staff $staff)
    {

        $form = $this->createForm(StaffType::class, $staff);
        $em = $this->getDoctrine()->getManager();
        $staffObj = $em->getRepository('AppBundle:Staff')->find($staff);

        $originalAllocations = new ArrayCollection();

        foreach ($staffObj->getAllocations() as $allocation) {
            $originalAllocations->add($allocation);
        }


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($staff->getAllocations() as $allocation) {
               $allocation->setStaff($staff);
            }

            foreach ($originalAllocations as $allocation) {
                if (false === $staff->getAllocations()->contains($allocation)) {
                    $em->remove($allocation);
                }
            }
            $em->persist($staff);
            $em->flush();
            return $this->redirectToRoute('show_staff', array('id' => $staff->getId()));
        }

        return $this->render('staff/show.html.twig', array(
            'staff' => $staff,
            'form' => $form->createView(),
        ));

    }

    /**
     * Deletes a staff entity.
     *
     * @Route("/{id}", name="delete_staff")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Staff $staff)
    {
        $form = $this->createDeleteForm($staff);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($staff);
            $em->flush();
        }
        return $this->redirectToRoute('index_staff');
    }

    /**
     * Creates a form to delete a staff entity
     * @param Staff $staff The staff entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Staff $staff)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_staff', array('id' => $staff->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
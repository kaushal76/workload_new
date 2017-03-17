<?php
namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Staff;
use AppBundle\Form\StaffType;
use AppBundle\Repository\AllocationRepository;
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

            return $this->redirectToRoute('index_staff', array('id' => $staff->getId()));
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
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($staff);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Staff details updated')
                ;
            }
            catch(\Exception $e){
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', $e->getMessage())
                ;
            }

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
                $allocation->setprepHrs($allocation->calculatePrepHrs($allocation->getItem()));
                $allocation->setAssessmentHrs($allocation->calculateAssessmentHrs($allocation->getItem()));
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
     * Displays a details of PhD student allocations for a Staff entity.
     *
     *
     * @Route("/{id}/phdstudent_allocation_details", name="staff_phdstudent_allocation_details")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function phdStudentAllocationDetailsAction(Staff $staff )
    {
        $em = $this->getDoctrine()->getManager();

        //PhD student queries
        $PhdAllocations = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findAllocationsForStaff($staff);
        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);


        return $this->render(':staff:modal.phdstudent.html.twig', array(
            'PhdAllocations' => $PhdAllocations,
            'PhdAllocationTotals' => $PhdAllocationTotals,
            'staff' => $staff,
        ));
    }


    /**
     * Displays a details of module allocations for a Staff entity.
     *
     * @param Request $request Staff $staff
     * @Route("/{id}/module_allocation_details", name="staff_module_allocation_details")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function moduleAllocationDetailsAction(Staff $staff )
    {

        $em = $this->getDoctrine()->getManager();

        //module queries
        $standardModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 2);
        $standardModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 2);
        $studioModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 3);
        $studioModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 3);
        $mixedModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 4);
        $mixedModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 4);
        $projectModulesUG = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 5 );
        $projectModulesUGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 5);
        $placementtModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 6 );
        $placementtModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 6);
        $projectModulesPG = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 7 );
        $projectModulesPGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 7);

        // Module leader queries
        $moduleLeaderHrs = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderForStaff($staff);
        $moduleLeaderHrsTotal = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderTotal($staff);
        $internalModeratorHrs = $em->getRepository('AppBundle:Module')
            ->findInternalModeratorForStaff($staff);
        $internalModeratorHrsTotal = $em->getRepository('AppBundle:Module')
            ->findinternalModeratorTotal($staff);


        return $this->render(':staff:modal.module.html.twig', array(
            'standardModules'=>$standardModules,
            'studioModules' => $studioModules,
            'mixedModules' => $mixedModules,
            'projectModulesUG' => $projectModulesUG,
            'projectModulesPG' => $projectModulesPG,
            'placementtModules' => $placementtModules,
            'standardModuleTotals' => $standardModuleTotals,
            'studioModuleTotals' => $studioModuleTotals,
            'mixedModuleTotals' => $mixedModuleTotals,
            'projectModulesUGTotals' =>  $projectModulesUGTotals,
            'placementModuleTotals' => $placementtModuleTotals,
            'projectModulesPGTotals' => $projectModulesPGTotals,
            'moduleLeaderHrs' => $moduleLeaderHrs,
            'internalModeratorHrs' => $internalModeratorHrs,
            'moduleLeaderHrsTotal' =>$moduleLeaderHrsTotal,
            'internalModeratorHrsTotal' => $internalModeratorHrsTotal,
            'staff'=>$staff,
        ));

    }

    /**
     * Displays a form to show an existing Staff entity.
     *
     * @param Request $request Staff $staff
     * @Route("/{id}/allocations", name="allocations_staff")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function allocationsAction(Request $request, Staff $staff )
    {
        $em = $this->getDoctrine()->getManager();

        //module queries
        $standardModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 2);
        $standardModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 2);
        $studioModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 3);
        $studioModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 3);
        $mixedModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 4);
        $mixedModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 4);
        $projectModulesUG = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 5 );
        $projectModulesUGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 5);
        $placementtModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 6 );
        $placementtModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 6);
        $projectModulesPG = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 7 );
        $projectModulesPGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 7);
        $ktpModules = $em->getRepository('AppBundle:AllocationsForModule')
            ->findAllocationsForStaffByCategory($staff, 8 );
        $ktpModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 8);

        //PhD student queries
        $PhdAllocations = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findAllocationsForStaff($staff);
        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);

        // Module leader queries
        $moduleLeaderHrs = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderForStaff($staff);
        $moduleLeaderHrsTotal = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderTotal($staff);
        $internalModeratorHrs = $em->getRepository('AppBundle:Module')
            ->findInternalModeratorForStaff($staff);
        $internalModeratorHrsTotal = $em->getRepository('AppBundle:Module')
            ->findinternalModeratorTotal($staff);

        //item queries

        $researchItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 3);
        $researchItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 3);
        $teachingRelatedItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 4);
        $teachingRelatedItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 4);
        $managementItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 5);
        $managementItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 5);
        $adminItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 6);
        $adminItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 6);

        return $this->render(':staff:summary.html.twig', array(
            'standardModules'=>$standardModules,
            'studioModules' => $studioModules,
            'mixedModules' => $mixedModules,
            'projectModulesUG' => $projectModulesUG,
            'projectModulesPG' => $projectModulesPG,
            'placementtModules' => $placementtModules,
            'PhdAllocations'=> $PhdAllocations,
            'standardModuleTotals' => $standardModuleTotals,
            'studioModuleTotals' => $studioModuleTotals,
            'mixedModuleTotals' => $mixedModuleTotals,
            'projectModulesUGTotals' =>  $projectModulesUGTotals,
            'placementModuleTotals' => $placementtModuleTotals,
            'PhdAllocationTotals' => $PhdAllocationTotals,
            'projectModulesPGTotals' => $projectModulesPGTotals,
            'moduleLeaderHrs' => $moduleLeaderHrs,
            'internalModeratorHrs' => $internalModeratorHrs,
            'moduleLeaderHrsTotal' =>$moduleLeaderHrsTotal,
            'internalModeratorHrsTotal' => $internalModeratorHrsTotal,
            'researchItems' => $researchItems,
            'researchItemTotals' => $researchItemTotals,
            'teachingRelatedItems' =>$teachingRelatedItems,
            'teachingRelatedItemTotals' =>$teachingRelatedItemTotals,
            'managementItems'=>$managementItems,
            'managementItemTotals'=> $managementItemTotals,
            'adminItems'=>$adminItems,
            'adminItemTotals' => $adminItemTotals,
            'ktpModules'=>$ktpModules,
            'ktpModuleTotals'=>$ktpModuleTotals,
            'staff' =>$staff,
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

    /**
     * Lists all Staff entities.
     *
     * @param Request $request Staff $staff
     * @Route("/{id}/summary", name="summary_staff")
     * @Method({"GET"})
     */
    public function summaryAction(Staff $staff)
    {
        $em = $this->getDoctrine()->getManager();

        //module queries

        $standardModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 2);
        $studioModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 3);
        $mixedModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 4);
        $projectModulesUGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 5);
        $placementtModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 6);
        $projectModulesPGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 7);
        $ktpModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 8);
        $moduleLeaderHrsTotal = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderTotal($staff);
        $internalModeratorHrsTotal = $em->getRepository('AppBundle:Module')
            ->findinternalModeratorTotal($staff);

        // PhD queries

        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);

        //item queries

        $researchItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 3);
        $researchItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 3);
        $teachingRelatedItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 4);
        $teachingRelatedItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 4);
        $managementItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 5);
        $managementItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 5);
        $adminItems = $em->getRepository('AppBundle:Allocation')
            ->findAllocationsForStaffByCategory($staff, 6);
        $adminItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 6);


        return $this->render(':staff:summary.html.twig', array(
            'standardModuleTotals' => $standardModuleTotals,
            'studioModuleTotals' => $studioModuleTotals,
            'mixedModuleTotals' => $mixedModuleTotals,
            'projectModulesUGTotals' =>  $projectModulesUGTotals,
            'placementModuleTotals' => $placementtModuleTotals,
            'PhdAllocationTotals' => $PhdAllocationTotals,
            'projectModulesPGTotals' => $projectModulesPGTotals,
            'moduleLeaderHrsTotal' =>$moduleLeaderHrsTotal,
            'internalModeratorHrsTotal' => $internalModeratorHrsTotal,
            'teachingRelatedItems' => $teachingRelatedItems,
            'teachingRelatedItemTotals' =>$teachingRelatedItemTotals,
            'managementItems' => $managementItems,
            'managementItemTotals'=> $managementItemTotals,
            'adminItems'=>$adminItems,
            'adminItemTotals' => $adminItemTotals,
            'ktpModuleTotals'=>$ktpModuleTotals,
            'researchItems'=> $researchItems,
            'researchItemTotals'=>$researchItemTotals,
            'staff' => $staff,
        ));
    }



    public function getHeadingTotalsAction(Staff $staff)
    {
        $em = $this->getDoctrine()->getManager();

        //module queries

        $standardModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 2);
        $studioModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 3);
        $mixedModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 4);
        $projectModulesUGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 5);
        $placementModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 6);
        $projectModulesPGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 7);
        $ktpModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 8);
        $moduleLeaderHrsTotal = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderTotal($staff);
        $internalModeratorHrsTotal = $em->getRepository('AppBundle:Module')
            ->findinternalModeratorTotal($staff);

        // PhD queries

        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);

        //item queries

        $researchItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 3);
        $teachingRelatedItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 4);
        $managementItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 5);
        $adminItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 6);



        $fst = $standardModuleTotals['totalAllocatedHrs'] + $studioModuleTotals['totalAllocatedHrs']
            + $mixedModuleTotals['totalAllocatedHrs'] +$projectModulesUGTotals['totalAllocatedHrs']
            + $projectModulesPGTotals['totalAllocatedHrs'] + $placementModuleTotals['totalAllocatedHrs']
            + $PhdAllocationTotals['totalAllocatedHrs'] + $ktpModuleTotals['totalAllocatedHrs'];

        $tra = $standardModuleTotals['totalPrepHrs'] + $studioModuleTotals['totalPrepHrs']
            + $mixedModuleTotals['totalPrepHrs'] + $standardModuleTotals['totalAssessmentHrs']
            + $studioModuleTotals['totalAssessmentHrs'] + $mixedModuleTotals['totalAssessmentHrs']
            + $PhdAllocationTotals['totalSupportHrs'] + $ktpModuleTotals['totalPrepHrs']
            + $moduleLeaderHrsTotal['moduleLeaderHrsTotal']
            + $internalModeratorHrsTotal['internalModeratorHrsTotal'] + $projectModulesPGTotals['totalAssessmentHrs']
            + $projectModulesUGTotals['totalAssessmentHrs'] + $teachingRelatedItemTotals['allocatedHrsTotal'];

        $re = $researchItemTotals['allocatedHrsTotal'];
        $mgt = $managementItemTotals['allocatedHrsTotal'];
        $admin = $adminItemTotals['allocatedHrsTotal'];

        $total = $fst+$tra+$re+$mgt+$admin;

        return $this->render(':staff:index.template.html.twig', array(
            'fst' => $fst,
            'tra' => $tra,
            're' => $re,
            'mgt' => $mgt,
            'admin'=>$admin,
            'total'=>$total,

        ));

    }

}
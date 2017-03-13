<?php


namespace AppBundle\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Staff;

class TotalCalculator
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $staff = $args->getEntity();

        // only act on some "Staff" entity
        if (!$staff instanceof Staff) {
            return;
        }

        $em = $args->getEntityManager();

        $standardModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 2);
        $staff->setStandardModuleTotals($standardModuleTotals);

        $studioModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 3);
        $staff->setStudioModuleTotals($studioModuleTotals);

        $mixedModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 4);
        $staff->setMixedModuleTotals($mixedModuleTotals);

        $projectModulesUGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 5);
        $staff->setProjectModulesUGTotals($projectModulesUGTotals);

        $placementModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 6);
        $staff->setPlacementModuleTotals($placementModuleTotals);

        $projectModulesPGTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 7);
        $staff->setProjectModulesPGTotals($projectModulesPGTotals);

        $ktpModuleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findTotals($staff, 8);
        $staff->setKtpModuleTotals($ktpModuleTotals);

        $moduleLeaderHrsTotal = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderTotal($staff);
        $staff->setModuleLeaderHrsTotal($moduleLeaderHrsTotal);

        $internalModeratorHrsTotal = $em->getRepository('AppBundle:Module')
            ->findinternalModeratorTotal($staff);
        $staff->setInternalModeratorHrsTotal($internalModeratorHrsTotal);

        // PhD queries

        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);
        $staff->setPhdAllocationTotals($PhdAllocationTotals);

        //item queries

        $researchItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 3);
        $staff->setResearchItemTotals($researchItemTotals);

        $teachingRelatedItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 4);
        $staff->setTeachingRelatedItemTotals($teachingRelatedItemTotals);

        $managementItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 5);
        $staff->setManagementItemTotals($managementItemTotals);

        $adminItemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotals($staff, 6);
        $staff->setAdminItemTotals($adminItemTotals);


        $fst = $standardModuleTotals['totalAllocatedHrs'] + $studioModuleTotals['totalAllocatedHrs']
            + $mixedModuleTotals['totalAllocatedHrs'] +$projectModulesUGTotals['totalAllocatedHrs']
            + $projectModulesPGTotals['totalAllocatedHrs'] + $placementModuleTotals['totalAllocatedHrs']
            + $PhdAllocationTotals['totalAllocatedHrs'] + $ktpModuleTotals['totalAllocatedHrs'];
        $staff->setFst($fst);

        $tra = $standardModuleTotals['totalPrepHrs'] + $studioModuleTotals['totalPrepHrs']
            + $mixedModuleTotals['totalPrepHrs'] + $standardModuleTotals['totalAssessmentHrs']
            + $studioModuleTotals['totalAssessmentHrs'] + $mixedModuleTotals['totalAssessmentHrs']
            + $PhdAllocationTotals['totalSupportHrs'] + $ktpModuleTotals['totalPrepHrs']
            + $moduleLeaderHrsTotal['moduleLeaderHrsTotal']
            + $internalModeratorHrsTotal['internalModeratorHrsTotal'] + $projectModulesPGTotals['totalAssessmentHrs']
            + $projectModulesUGTotals['totalAssessmentHrs'] + $teachingRelatedItemTotals['allocatedHrsTotal'];
        $staff->setTra($tra);

        $re = $researchItemTotals['allocatedHrsTotal'];
        $staff->setRe($re);

        $mgt = $managementItemTotals['allocatedHrsTotal'];
        $staff->setMgt($mgt);

        $admin = $adminItemTotals['allocatedHrsTotal'];
        $staff->setAdmin($admin);

        $total = $fst+$tra+$re+$mgt+$admin;
        $staff->setTotal($total);
    }
}
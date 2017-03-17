<?php


namespace AppBundle\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Staff;

class TotalCalculator
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $staff = $args->getEntity();

        // only act on "Staff" entity
        if (!$staff instanceof Staff) {
            return;
        }

        // Module queries
        $em = $args->getEntityManager();

        $moduleTotals = $em->getRepository('AppBundle:AllocationsForModule')
            ->findModuleTotals($staff);

        //Module leader and internal moderator queries
        $moduleLeaderAndInternalModerator = $em->getRepository('AppBundle:Module')
            ->findModuleLeaderInternalModeratorTotal($staff);

        // PhD queries
        $PhdAllocationTotals = $em->getRepository('AppBundle:AllocationsForPhdStudent')
            ->findTotals($staff);

        //item queries
        $itemTotals = $em->getRepository('AppBundle:Allocation')
            ->findTotalsCombined($staff);

        //Calculations
        $fst = $moduleTotals['standardTotalAllocatedHrs'] + $moduleTotals['studioTotalAllocatedHrs']
            + $moduleTotals['mixedTotalAllocatedHrs'] +$moduleTotals['projectUGTotalAllocatedHrs']
            + $moduleTotals['placementTotalAllocatedHrs'] + $moduleTotals['projectPGTotalAllocatedHrs']
            + $PhdAllocationTotals['totalAllocatedHrs'] + $moduleTotals['KTPTotalAllocatedHrs'];
        $staff->setFst($fst);

        $tra = $moduleTotals['standardTotalPrepHrs'] + $moduleTotals['studioTotalPrepHrs']
            + $moduleTotals['mixedTotalPrepHrs'] + $moduleTotals['standardTotalAssessmentHrs']
            + $moduleTotals['studioTotalAssessmentHrs'] + $moduleTotals['mixedTotalAssessmentHrs']
            + $PhdAllocationTotals['totalSupportHrs'] + $moduleTotals['KTPTotalPrepHrs']
            + $moduleLeaderAndInternalModerator['moduleLeaderHrsTotal']
            + $moduleLeaderAndInternalModerator['internalModeratorHrsTotal'] + $moduleTotals['projectPGTotalAssessmentHrs']
            + $moduleTotals['projectUGTotalAssessmentHrs'] + $itemTotals['teachingRelatedAllocatedHrsTotal'];
        $staff->setTra($tra);

        $re = $itemTotals['researchAllocatedHrsTotal'];
        $staff->setRe($re);

        $mgt = $itemTotals['managementAllocatedHrsTotal'];
        $staff->setMgt($mgt);

        $admin = $itemTotals['adminAllocatedHrsTotal'];
        $staff->setAdmin($admin);

        $total = $fst+$tra+$re+$mgt+$admin;
        $staff->setTotal($total);

    }
}
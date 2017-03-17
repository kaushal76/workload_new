<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Staff;
use Doctrine\ORM\EntityRepository;

/**
 * AlloactionForModuleRepository
 *
 */
class AlloactionsForModuleRepository extends EntityRepository
{
    public function findAllocationsForStaffByCategory($staff, $category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT p
          FROM AppBundle:AllocationsForModule p
          LEFT JOIN AppBundle:Module r WITH p.module = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff) AND (r.moduleCategory= :category)
          ')
            ->setParameter('staff', $staff)
            ->setParameter('category', $category);

        $allocations = $query->getResult();
        return $allocations;

    }

    public function findTotals($staff, $category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT SUM(p.prepHrs) as totalPrepHrs, SUM(p.allocatedHrs) AS totalAllocatedHrs, SUM(p.assessmentHrs) as totalAssessmentHrs
          FROM AppBundle:AllocationsForModule p
          LEFT JOIN AppBundle:Module r WITH p.module = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff) AND (r.moduleCategory= :category)
          ')
            ->setParameter('staff', $staff)
            ->setParameter('category', $category);

        $totals = $query->getOneOrNullResult();

        return $totals;

    }

    public function findTotalsEx($staff)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT 
           SUM(CASE WHEN r.moduleCategory = 2 THEN p.prepHrs ELSE 0 END) AS StandardTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 2 THEN p.allocatedHrs ELSE 0 END) AS StandardTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 2 THEN p.assessmentHrs ELSE 0 END) AS StandardTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 3 THEN p.prepHrs ELSE 0 END) AS StudioTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 3 THEN p.allocatedHrs ELSE 0 END) AS StudioTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 3 THEN p.assessmentHrs ELSE 0 END) AS StudioTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 4 THEN p.prepHrs ELSE 0 END) AS MixedTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 4 THEN p.allocatedHrs ELSE 0 END) AS MixedTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 4 THEN p.assessmentHrs ELSE 0 END) AS MixedTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 5 THEN p.prepHrs ELSE 0 END) AS ProjectUGTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 5 THEN p.allocatedHrs ELSE 0 END) AS ProjectUGTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 5 THEN p.assessmentHrs ELSE 0 END) AS ProjectUGTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 6 THEN p.prepHrs ELSE 0 END) AS PlacementTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 6 THEN p.allocatedHrs ELSE 0 END) AS PlacementTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 6 THEN p.assessmentHrs ELSE 0 END) AS PlacementTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 7 THEN p.prepHrs ELSE 0 END) AS ProjectPGTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 7 THEN p.allocatedHrs ELSE 0 END) AS ProjectPGTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 7 THEN p.assessmentHrs ELSE 0 END) AS ProjectPGTotalAssessmentHrs,
           
           SUM(CASE WHEN r.moduleCategory = 8 THEN p.prepHrs ELSE 0 END) AS KTPTotalPrepHrs,
           SUM(CASE WHEN r.moduleCategory = 8 THEN p.allocatedHrs ELSE 0 END) AS KTPTotalAllocatedHrs,
           SUM(CASE WHEN r.moduleCategory = 8 THEN p.assessmentHrs ELSE 0 END) AS KTPTotalAssessmentHrs
           
          FROM AppBundle:AllocationsForModule p
          LEFT JOIN AppBundle:Module r WITH p.module = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff)
          ')
            ->setParameter('staff', $staff);
        $totals = $query->getOneOrNullResult();

        return $totals;

    }

}

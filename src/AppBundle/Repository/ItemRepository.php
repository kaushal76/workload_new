<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Staff;
use Doctrine\ORM\EntityRepository;

/**
 * ItemRepository
 *
 */
class ItemRepository extends EntityRepository
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
}
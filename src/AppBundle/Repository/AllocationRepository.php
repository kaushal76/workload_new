<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * AllocationRepository
 *
 */
class AllocationRepository extends EntityRepository
{
    public function findAllocationsForStaffByCategory($staff, $category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT p
          FROM AppBundle:Allocation p
          LEFT JOIN AppBundle:Item r WITH p.item = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff) AND (r.category= :category)
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
          SELECT SUM(p.allocatedHrs) as allocatedHrsTotal
        FROM AppBundle:Allocation p
          LEFT JOIN AppBundle:Item r WITH p.item = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff) AND (r.category= :category)
          ')
            ->setParameter('staff', $staff)
            ->setParameter('category', $category);

        $totals = $query->getOneOrNullResult();

        return $totals;

    }

    public function findTotalsCombined($staff)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT 
          SUM(CASE WHEN r.category = 3 THEN p.allocatedHrs ELSE 0 END) AS ResearchAllocatedHrsTotal,
          SUM(CASE WHEN r.category = 4 THEN p.allocatedHrs ELSE 0 END) AS TeachingRelatedAllocatedHrsTotal,
          SUM(CASE WHEN r.category = 5 THEN p.allocatedHrs ELSE 0 END) AS ManagementAllocatedHrsTotal,
          SUM(CASE WHEN r.category = 6 THEN p.allocatedHrs ELSE 0 END) AS AdminAllocatedHrsTotal
          FROM AppBundle:Allocation p
          LEFT JOIN AppBundle:Item r WITH p.item = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff)
          ')
            ->setParameter('staff', $staff);

        $totals = $query->getOneOrNullResult();

        return $totals;

    }




}

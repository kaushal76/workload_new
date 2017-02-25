<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * AlloactionRepository
 *
 */
class AlloactionRepository extends EntityRepository
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
}

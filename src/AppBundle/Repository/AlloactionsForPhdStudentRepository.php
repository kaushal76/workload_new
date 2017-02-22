<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Staff;
use Doctrine\ORM\EntityRepository;

/**
 * AlloactionsForPhdStudentRepository
 *
 *
 */
class AlloactionsForPhdStudentRepository extends EntityRepository
{
    public function findAllocationsForStaff($staff)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT p
          FROM AppBundle:AllocationsForPhdStudent p
          LEFT JOIN AppBundle:PhdStudent r WITH p.phdStudent = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff)
          ')
            ->setParameter('staff', $staff);

        $allocations = $query->getResult();

        return $allocations;

    }

    public function findTotals($staff)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT SUM(p.supportHrs) as totalSupportHrs, SUM(p.allocatedHrs) AS totalAllocatedHrs
          FROM AppBundle:AllocationsForPhdStudent p
          LEFT JOIN AppBundle:Module r WITH p.phdStudent = r.id
          LEFT JOIN AppBundle:Staff s WITH p.staff = s.id
          WHERE (p.staff = :staff)
          ')
            ->setParameter('staff', $staff);

        $totals = $query->getOneOrNullResult();

        return $totals;

    }

}

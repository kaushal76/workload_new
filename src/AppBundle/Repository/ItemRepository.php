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

    public function findItembyStaffbyCategory($staff, $category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT p.name As name, r.allocatedHrs as allocatedHrs
          FROM AppBundle:Item p
          LEFT JOIN AppBundle:Allocation r WITH p.id = r.item 
          INNER JOIN AppBundle:Staff s WITH r.staff = s.id
          WHERE (r.staff = :staff) AND (p.category = :category)
          ')
            ->setParameter('staff', $staff)
            ->setParameter('category', $category);

        $item = $query->getResult();
        return $item;

    }

    public function findItembyStaffbyCategoryTotal($staff, $category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
          SELECT SUM(r.allocatedHrs) as allocatedHrs
          FROM AppBundle:Item p
          LEFT JOIN AppBundle:Allocation r WITH p.id = r.item 
          INNER JOIN AppBundle:Staff s WITH r.staff = s.id
          WHERE (r.staff = :staff) AND (p.category = :category)
          ')
            ->setParameter('staff', $staff)
            ->setParameter('category', $category);

        $totals = $query->getOneOrNullResult();
        return $totals;

    }
}

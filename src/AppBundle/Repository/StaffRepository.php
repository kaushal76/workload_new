<?php

namespace AppBundle\Repository;

/**
 * StaffRepository
 *
 */
class StaffRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('surname' => 'ASC'));
    }
}

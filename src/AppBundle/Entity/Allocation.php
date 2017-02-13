<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Allocation
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="allocations")
 */
class Allocation {


    /**
     *
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="allocations")
     * @ORM\JoinColumn(name="staff", referencedColumnName="id")
     */
    protected $staff;

    /**
     *
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Item", inversedBy="allocations")
     * @ORM\JoinColumn(name="item", referencedColumnName="id")
     */
    protected $item;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $allocatedHrs;

    /**
     * @return int
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * @return int
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return int
     */
    public function getAllocatedHrs()
    {
        return $this->allocatedHrs;
    }

    /**
     * @param int $staff
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }

    /**
     * @param int
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @param int $allocatedHrs
     */
    public function setAllocatedHrs($allocatedHrs)
    {
        $this->allocatedHrs = $allocatedHrs;
    }

}
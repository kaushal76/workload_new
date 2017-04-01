<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Allocation
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="allocations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AllocationRepository")
 */
class Allocation {


    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="allocations")
     * @ORM\JoinColumn(name="staff", referencedColumnName="id")
     */
    protected $staff;

    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Item", inversedBy="allocations")
     * @ORM\JoinColumn(name="item", referencedColumnName="id")
     */
    protected $item;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $allocatedHrs;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */

    protected $prepHrs;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */

    protected $assessmentHrs;

    /**
     * @return mixed
     */
    public function getAssessmentHrs()
    {
        return $this->assessmentHrs;
    }

    /**
     * @param mixed $assessmentHrs
     */
    public function setAssessmentHrs($assessmentHrs)
    {
        $this->assessmentHrs = $assessmentHrs;
    }


    /**
     * @return mixed
     */
    public function getPrepHrs()
    {
        return $this->prepHrs;
    }

    /**
     * @param mixed $prepHrs
     */
    public function setPrepHrs($prepHrs)
    {
        $this->prepHrs = $prepHrs;
    }

    /**
     * @return int
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * @return Item
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

    /*
     * @return
     */
    public function calculatePrepHrs(Item $item)
    {
        $module = $item->getModule();
        $prepHrs = 0;
        if (is_object($module))
        {
            $moduleContactHrs = $module->calculateContactHrs();
            $modulePrepHrs = $module->calculatePreparationHrs();
            $allocatedHrs = $this->getAllocatedHrs();

            $prepHrs = (float)$allocatedHrs * (float)$modulePrepHrs/(float)$moduleContactHrs;
        }
        return $prepHrs;
    }

    /*
     * @return
     */
    public function calculateAssessmentHrs(Item $item)
    {
        $module = $item->getModule();
        $AssessmentHrs = 0;
        if (is_object($module))
        {
            $moduleContactHrs = $module->calculateContactHrs();
            $moduleAssHrs = $module->calculateAssessmentHrs();
            $allocatedHrs = $this->getAllocatedHrs();

            $AssessmentHrs= (float)$allocatedHrs * (float)$moduleAssHrs/(float)$moduleContactHrs;
        }
        return $AssessmentHrs;
    }
}

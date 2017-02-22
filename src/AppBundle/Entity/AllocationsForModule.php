<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AllocationsForModule
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="allocations_for_module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlloactionsForModuleRepository")
 */
class AllocationsForModule {


    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="allocationsForModule")
     * @ORM\JoinColumn(name="staff", referencedColumnName="id")
     */
    protected $staff;

    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module", inversedBy="allocationsForModule")
     * @ORM\JoinColumn(name="module", referencedColumnName="id")
     */
    protected $module;

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
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }


    /**
     * @return float
     */
    public function getAssessmentHrs()
    {
        return $this->assessmentHrs;
    }

    /**
     * @param float $assessmentHrs
     */
    public function setAssessmentHrs($assessmentHrs)
    {
        $this->assessmentHrs = $assessmentHrs;
    }


    /**
     * @return float
     */
    public function getPrepHrs()
    {
        return $this->prepHrs;
    }

    /**
     * @param float $prepHrs
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
     * @param int $allocatedHrs
     */
    public function setAllocatedHrs($allocatedHrs)
    {
        $this->allocatedHrs = $allocatedHrs;
    }

    /*
   * @return
   */
    public function calculatePrepHrs(Module $module)
    {
        $prepHrs = 0;
        if (is_object($module))
        {
            $moduleContactHrs = $module->getContactHrs();
            $modulePrepHrs = $module->getPreparationHrs();
            $allocatedHrs = $this->getAllocatedHrs();

            $prepHrs = (float)$allocatedHrs * (float)$modulePrepHrs/(float)$moduleContactHrs;
        }
        return $prepHrs;
    }

    /*
     * @return
     */
    public function calculateAssessmentHrs(Module $module)
    {
        $AssessmentHrs = 0;
        if (is_object($module))
        {
            $moduleContactHrs = $module->getContactHrs();
            $moduleAssHrs = $module->getAssessmentHrs();
            $allocatedHrs = $this->getAllocatedHrs();

            $AssessmentHrs= (float)$allocatedHrs * (float)$moduleAssHrs/(float)$moduleContactHrs;
        }
        return $AssessmentHrs;
    }
}

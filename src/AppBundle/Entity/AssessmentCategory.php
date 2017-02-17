<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AssessmentCategory
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="assessment_category")
 */
class AssessmentCategory {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Module", mappedBy="assessmentCategory", cascade={"persist"})
     */

    protected $modules;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $code;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $studioAssessmentHrs;


    /**
     * AssessmentCategory constructor.
     */

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }


    /**
     * @return float
     */
    public function getStudioAssessmentHrs()
    {
        return $this->studioAssessmentHrs;
    }

    /**
     * @param float $studioAssessmentHrs
     */
    public function setStudioAssessmentHrs($studioAssessmentHrs)
    {
        $this->studioAssessmentHrs = $studioAssessmentHrs;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param mixed $modules
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    /**
     * Add Module
     *
     * @param Module $module
     * @return AssessmentCategory
     */
    public function addModule(Module $module)
    {

        $module->setModuleCategory($this);

        if (!$this->getModules()->contains($module)) {
            $this->modules->add($module);
        }

        return $this;
    }

    /**
     * Remove Modules
     *
     * @param Module $module
     */
    public function removeModule(Module $module)
    {
        $this->modules->removeElement($module);
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->code.' '.$this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}

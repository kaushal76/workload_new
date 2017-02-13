<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Module
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="module")
 */
class Module {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * One module leader one staff .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Item", inversedBy="module")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="modules")
     * @ORM\JoinColumn(name="course", referencedColumnName="id")
     */
    protected $course;
    /**
     * @ORM\Column(type="integer")
     */
    protected $term;
    /**
     * @ORM\Column(type="integer")
     */
    protected $year;
    /**
     * @ORM\Column(type="integer")
     */
    protected $credit;
    /**
     * @ORM\Column(type="integer")
     */
    protected $studentNos;
    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ModuleCategory", inversedBy="modules")
     * @ORM\JoinColumn(name="module_category", referencedColumnName="id")
     */
    protected $moduleCategory;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GroupFilter", inversedBy="modules")
     * @ORM\JoinColumn(name="group_filter", referencedColumnName="id")
     */
    protected $groupFilter;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AssessmentCategory", inversedBy="modules")
     * @ORM\JoinColumn(name="assessment_category", referencedColumnName="id")
     */
    protected $assessmentCategory;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PreparationCategory", inversedBy="modules")
     * @ORM\JoinColumn(name="preparation_category", referencedColumnName="id")
     */
    protected $preparationCategory;
    /**
     * @ORM\Column(type="integer")
     */
    protected $preparationHrs;
    /**
     * @ORM\Column(type="integer")
     */
    protected $assessmentHrs;
    /**
     * @ORM\Column(type="integer")
     */
    protected $contactHrs;
    /**
     * @ORM\Column(type="integer")
     */
    protected $studioRatio;

    /**
     * One module leader one staff .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Staff")
     * @ORM\JoinColumn(name="moduleLeader", referencedColumnName="id")
     */
    protected $moduleLeader;

    /**
     * One internal Moderator one staff .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Staff")
     * @ORM\JoinColumn(name="internalModerator", referencedColumnName="id")
     */
    protected $internalModerator;

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
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param mixed $credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }

    /**
     * @return mixed
     */
    public function getStudentNos()
    {
        return $this->studentNos;
    }

    /**
     * @param mixed $studentNos
     */
    public function setStudentNos($studentNos)
    {
        $this->studentNos = $studentNos;
    }

    /**
     * @return mixed
     */
    public function getModuleCategory()
    {
        return $this->moduleCategory;
    }

    /**
     * @param mixed $moduleCategory
     */
    public function setModuleCategory($moduleCategory)
    {
        $this->moduleCategory = $moduleCategory;
    }

    /**
     * @return int
     */
    public function getGroupFilter()
    {
        return $this->groupFilter;
    }

    /**
     * @param int $groupFilter
     */
    public function setGroupFilter($groupFilter)
    {
        $this->groupFilter = $groupFilter;
    }

    /**
     * @return int
     */
    public function getAssessmentCategory()
    {
        return $this->assessmentCategory;
    }

    /**
     * @param int $assessmentCategory
     */
    public function setAssessmentCategory($assessmentCategory)
    {
        $this->assessmentCategory = $assessmentCategory;
    }

    /**
     * @return int
     */
    public function getPreparationCategory()
    {
        return $this->preparationCategory;
    }

    /**
     * @param int $preparationCategory
     */
    public function setPreparationCategory($preparationCategory)
    {
        $this->preparationCategory = $preparationCategory;
    }

    /**
     * @return mixed
     */
    public function getPreparationHrs()
    {
        return $this->preparationHrs;
    }

    /**
     * @param mixed $preparationHrs
     */
    public function setPreparationHrs($preparationHrs)
    {
        $this->preparationHrs = $preparationHrs;
    }

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
    public function getContactHrs()
    {
        return $this->contactHrs;
    }

    /**
     * @param mixed $contactHrs
     */
    public function setContactHrs($contactHrs)
    {
        $this->contactHrs = $contactHrs;
    }

    /**
     * @return mixed
     */
    public function getStudioRatio()
    {
        return $this->studioRatio;
    }

    /**
     * @param mixed $studioRatio
     */
    public function setStudioRatio($studioRatio)
    {
        $this->studioRatio = $studioRatio;
    }

    /**
     * @return mixed
     */
    public function getModuleLeader()
    {
        return $this->moduleLeader;
    }

    /**
     * @param mixed $moduleLeader
     */
    public function setModuleLeader($moduleLeader)
    {
        $this->moduleLeader = $moduleLeader;
    }

    /**
     * @return mixed
     */
    public function getInternalModerator()
    {
        return $this->internalModerator;
    }

    /**
     * @param mixed $internalModerator
     */
    public function setInternalModerator($internalModerator)
    {
        $this->internalModerator = $internalModerator;
    }



}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Module
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     *
     * Many modules have many courses
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Course", inversedBy="modules")
     * @ORM\JoinTable(name="modules_courses")
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $preparationHrs;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $assessmentHrs;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $contactHrs;
    /**
     * @ORM\Column(type="float")
     */
    protected $studioRatio;

    /**
     * One module leader one staff .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Item", inversedBy="module")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     *
     */

    protected $item;


    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $groupFactor;


    /**
     * One module leader one staff .
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="moduleLeaders")
     * @ORM\JoinColumn(name="moduleLeader", referencedColumnName="id")
     */
    protected $moduleLeader;

    /**
     * One internal Moderator one staff .
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="internalModerators")
     * @ORM\JoinColumn(name="internalModerator", referencedColumnName="id")
     */
    protected $internalModerator;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $moduleLeaderHrs;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $internalModeratorHrs;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    protected $comments;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;


    /**
     * @var
     * @ORM\Column(type="boolean")
     */
    protected $manualContactHrsInput;


    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"comment"})
     */
    protected $contentChanged;

    /**
     * @return mixed
     */
    public function getManualContactHrsInput()
    {
        return $this->manualContactHrsInput;
    }

    /**
     * @param mixed $manualContactHrsInput
     */
    public function setManualContactHrsInput($manualContactHrsInput)
    {
        $this->manualContactHrsInput = $manualContactHrsInput;
    }


    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getContentChanged()
    {
        return $this->contentChanged;
    }

    /**
     * @param \DateTime $contentChanged
     */
    public function setContentChanged($contentChanged)
    {
        $this->contentChanged = $contentChanged;
    }


    /**
     * @return mixed
     */
    public function getModuleLeaderHrs()
    {
        return $this->moduleLeaderHrs;
    }

    /**
     * @param mixed $moduleLeaderHrs
     */
    public function setModuleLeaderHrs($moduleLeaderHrs)
    {
        $this->moduleLeaderHrs = $moduleLeaderHrs;
    }

    /**
     * @return mixed
     */
    public function getInternalModeratorHrs()
    {
        return $this->internalModeratorHrs;
    }

    /**
     * @param mixed $internalModeratorHrs
     */
    public function setInternalModeratorHrs($internalModeratorHrs)
    {
        $this->internalModeratorHrs = $internalModeratorHrs;
    }


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AllocationsForModule", mappedBy="module", cascade={"persist", "remove"})
     */

    protected $allocationsForModule;

    /**
     * Module constructor.
     */

    public function __construct()
    {
        $this->allocationsForModule = new ArrayCollection();
        $this->course = new ArrayCollection();
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
    public function getAllocationsForModule()
    {
        return $this->allocationsForModule;
    }

    /**
     * @param mixed $allocationsformodule
     */
    public function setAllocationsForModule($allocationsformodule)
    {
        $this->allocationsForModule = $allocationsformodule;
    }



    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return float
     */
    public function getGroupFactor()
    {
        return $this->groupFactor;
    }

    /**
     * @param float $groupFactor
     */
    public function setGroupFactor($groupFactor)
    {
        $this->groupFactor = $groupFactor;
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
     * @param mixed $preparationCategory
     */
    public function setPreparationCategory($preparationCategory)
    {
        $this->preparationCategory = $preparationCategory;
    }

    public function getPreparationHrs()
    {
        return $this->preparationHrs;
    }



    public function calculatePreparationHrs()
    {
        $credit = $this->getCredit();
        $mode = $this->getModuleCategory();
        $studio = $this->getStudioRatio();
        $preparationCategory = $this->getPreparationCategory();
        $studioPrepHrs = $preparationCategory->getStudioPrepHrs();

        $preparationHrs = $this->getPreparationHrs();

        if ($mode->getCode() == 1) {
            $preparationHrs = (int)$credit * (float)$preparationCategory->getCode();
        }

        if ($mode->getCode() == 2) {
            $preparationHrs = $studioPrepHrs;
        }

        if ($mode->getCode() == 3) {

            $preparationHrs = ((int)$credit * (float)$preparationCategory->getCode() * (1-((float)$studio)))+((float)$studioPrepHrs * (float)$studio);
        }

        if ($mode->getCode() == 6) {

            $preparationHrs = $this->getPreparationHrs();
        }

        return $preparationHrs;
    }

    /**
     * Add AllocationsForModule
     *
     * @param AllocationsForModule $allocationsForModule
     *
     * @return Module
     */
    public function addAllocationsForModule(AllocationsForModule $allocationsForModule)
    {
        $allocationsForModule->setModule($this);

        if (!$this->getAllocationsForModule()->contains($allocationsForModule)) {
            $this->allocationsForModule->add($allocationsForModule);
        }

        return $this;
    }

    /**
     * Remove allocationsformodule
     *
     * @param AllocationsForModule $allocationsformodule
     */
    public function removeAllocationsForModule(AllocationsForModule $allocationsForModule)
    {
        $this->allocationsForModule->removeElement($allocationsForModule);
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
     * @return mixed
     */
    public function getContactHrs()
    {
        return $this->contactHrs;
    }



    public function calculateAssessmentHrs()
    {
        $credit = $this->getCredit();
        $mode = $this->getModuleCategory();
        $studentNumbers = $this->getStudentNos();
        $studio = $this->getStudioRatio();
        $assessmentCategory = $this->getAssessmentCategory();
        $studioAssessmentHrs = $assessmentCategory->getStudioAssessmentHrs();

        $assessmentHrs = $this->getAssessmentHrs();

        if ($mode->getCode() == 1) {
            $assessmentHrs = (float)$credit * (float)$assessmentCategory->getCode() * (float)$studentNumbers;
        }

        if ($mode->getCode() == 2) {
            $assessmentHrs = $studioAssessmentHrs * (float)$credit * (float)$studentNumbers;
        }

        if ($mode->getCode() == 3) {

            $assessmentHrs = ((int)$credit * (float)$assessmentCategory->getCode() * (1-((float)$studio)) * (float)$studentNumbers)+((float)$studioAssessmentHrs * (float)$studio * (float)$credit * (float)$studentNumbers);
        }

        if ($mode->getCode() == 4) {

            $assessmentHrs = (float)$credit * (float)$assessmentCategory->getCode() * (float)$studentNumbers;
        }

        return $assessmentHrs;
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
    public function calculateContactHrs()
    {
        $credit = $this->getCredit();
        $mode = $this->getModuleCategory();
        $studentNumbers = $this->getStudentNos();
        $studio = $this->getStudioRatio();
        $groupFactor = $this->getGroupFactor();
        $contactHrsfactor = $mode->getContactHrsFactor();

        $contactHrs = $this->getContactHrs();

        if ($this->getManualContactHrsInput()) {
            return $contactHrs;
        }
        if ($mode->getCode() == 1) {
            $contactHrs = (float)$credit * (float)$contactHrsfactor;
        }

        if ($mode->getCode() == 2) {
            $contactHrs = (float)$credit * (float)$contactHrsfactor * (float)$groupFactor;
        }

        if ($mode->getCode() == 3) {

            $contactHrs = ((float)$credit * (float)$contactHrsfactor * (1-((float)$studio)))+((float)$credit * (float)$contactHrsfactor * (float)$groupFactor * (float)$studio);
        }

        if ($mode->getCode() == 4) {

            $contactHrs = (float)$contactHrsfactor * (float)$studentNumbers;
        }

        if ($mode->getCode() == 5) {

            $contactHrs = (float)$contactHrsfactor;
        }

        if ($mode->getCode() == 6) {

            $contactHrs = $this->getContactHrs();
        }

        return $contactHrs;
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

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

}

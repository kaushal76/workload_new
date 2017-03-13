<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Staff
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="staff")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StaffRepository")
 */

class Staff {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Allocation", mappedBy="staff", cascade={"persist", "remove"})
     */

    protected $allocations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AllocationsForModule", mappedBy="staff", cascade={"persist", "remove"})
     */

    protected $allocationsForModule;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AllocationsForPhdStudent", mappedBy="staff", cascade={"persist", "remove"})
     */

    protected $allocationsForPhdStudent;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $surname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $fte;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Module", mappedBy="moduleLeader", cascade={"persist"})
     */
    protected $moduleLeaders;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Module", mappedBy="internalModerator", cascade={"persist"})
     */
    protected $internalModerators;


    /**
     * Totals
     */

    protected $standardModuleTotals;
    protected $studioModuleTotals;
    protected $mixedModuleTotals;
    protected $projectModulesUGTotals;
    protected $placementModuleTotals;
    protected $projectModulesPGTotals;
    protected $ktpModuleTotals;
    protected $moduleLeaderHrsTotal;
    protected $internalModeratorHrsTotal;
    protected $PhdAllocationTotals;
    protected $researchItemTotals;
    protected $teachingRelatedItemTotals;
    protected $managementItemTotals;
    protected $adminItemTotals;

    protected $fst;
    protected $tra;
    protected $re;
    protected $mgt;
    protected $admin;
    protected $total;

    /**
     * Staff constructor.
     */

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
        $this->allocationsForModule = new ArrayCollection();
        $this->allocationsForPhdStudent = new ArrayCollection();
        $this->internalModerators = new ArrayCollection();
        $this->moduleLeaders = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getFte()
    {
        return $this->fte;
    }

    /**
     * @return mixed
     */
    public function getModuleLeaders()
    {
        return $this->moduleLeaders;
    }

    /**
     * @param mixed $moduleLeaders
     */
    public function setModuleLeaders($moduleLeaders)
    {
        $this->moduleLeaders = $moduleLeaders;
    }

    /**
     * @return mixed
     */
    public function getInternalModerators()
    {
        return $this->internalModerators;
    }

    /**
     * @param mixed $internalModerators
     */
    public function setInternalModerators($internalModerators)
    {
        $this->internalModerators = $internalModerators;
    }



    /**
     * @param mixed $fte
     */
    public function setFte($fte)
    {
        $this->fte = $fte;
    }

    /**
     * @return mixed
     */
    public function getAllocationsForPhdStudent()
    {
        return $this->allocationsForPhdStudent;
    }

    /**
     * @param mixed $allocationsForPhdStudent
     */
    public function setAllocationsForPhdStudent($allocationsForPhdStudent)
    {
        $this->allocationsForPhdStudent = $allocationsForPhdStudent;
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
    public function getAllocations()
    {
        return $this->allocations;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $allocations
     */
    public function setAllocations($allocations)
    {
        $this->allocations = $allocations;
    }

    /**
     * @return mixed
     */
    public function getAllocationsForModule()
    {
        return $this->allocationsForModule;
    }

    /**
     * @param mixed $allocationsForModule
     */
    public function setAllocationsForModule($allocationsForModule)
    {
        $this->allocationsForModule = $allocationsForModule;
    }


    /**
     * Add Allocations
     *
     * @param Allocation $allocations
     *
     * @return Staff
     */
    public function addAllocation(Allocation $allocations)
    {

        $allocations->setStaff($this);

        if (!$this->getAllocations()->contains($allocations)) {
            $this->allocations->add($allocations);
        }

        return $this;
    }


    /**
     * Remove allocations
     *
     * @param Allocation $allocations
     */
    public function removeAllocation(Allocation $allocations)
    {
        $this->allocations->removeElement($allocations);
    }

    /**
     * Add internalModerators
     *
     * @param
     *
     * @return Staff
     */
    public function addInternalModerator(Module $modules)
    {

        $modules->setInternalModerator($this);

        if (!$this->getInternalModerators()->contains($modules)) {
            $this->internalModerators->add($modules);
        }

        return $this;
    }

    /**
     * Remove internalModerators
     *
     * @param Module $module
     */
    public function removeInternalModerator(Module $modules)
    {
        $this->internalModerators->removeElement($modules);
    }

    /**
     * Add moduleLeader
     *
     * @param
     *
     * @return Staff
     */
    public function addModuleLeader(Module $modules)
    {

        $modules->setInternalModerator($this);

        if (!$this->getModuleLeaders()->contains($modules)) {
            $this->moduleLeaders->add($modules);
        }

        return $this;
    }

    /**
     * Remove moduleLeader
     *
     * @param Module $module
     */
    public function removeModuleLeader(Module $modules)
    {
        $this->moduleLeaders->removeElement($modules);
    }

    /**
     * Add AllocationsForModule
     *
     * @param AllocationsForModule $allocationsForModule
     *
     * @return Staff
     */
    public function addAllocationForModule(AllocationsForModule $allocationsForModule)
    {

        $allocationsForModule->setStaff($this);

        if (!$this->getAllocationsForModule()->contains($allocationsForModule)) {
            $this->allocationsForModule->add($allocationsForModule);
        }

        return $this;
    }

    /**
     * Remove allocationsForModule
     *
     * @param AllocationsForModule $allocationsForModule
     */
    public function removeAllocationForModule(AllocationsForModule $allocationsForModule)
    {
        $this->allocationsForModule->removeElement($allocationsForModule);
    }

    /**
     * Add AllocationsForPhdStudent
     *
     * @param AllocationsForPhdStudent $allocationsForPhdStudent
     *
     * @return Staff
     */
    public function addAllocationForPhdStudent(AllocationsForPhdStudent $allocationsForPhdStudent)
    {

        $allocationsForPhdStudent->setStaff($this);

        if (!$this->getAllocationsForPhdStudent()->contains($allocationsForPhdStudent)) {
            $this->allocationsForPhdStudent->add($allocationsForPhdStudent);
        }

        return $this;
    }

    /**
     * Remove AllocationsForPhdStudent
     *
     * @param AllocationsForPhdStudent $allocationsForPhdStudent
     */
    public function removeAllocationForPhdStudent(AllocationsForPhdStudent $allocationsForPhdStudent)
    {
        $this->allocationsForPhdStudent->removeElement($allocationsForPhdStudent);
    }

    /**
     * @return mixed
     */
    public function getStandardModuleTotals()
    {
        return $this->standardModuleTotals;
    }

    /**
     * @param mixed $standardModuleTotals
     */
    public function setStandardModuleTotals($standardModuleTotals)
    {
        $this->standardModuleTotals = $standardModuleTotals;
    }

    /**
     * @return mixed
     */
    public function getStudioModuleTotals()
    {
        return $this->studioModuleTotals;
    }

    /**
     * @param mixed $studioModuleTotals
     */
    public function setStudioModuleTotals($studioModuleTotals)
    {
        $this->studioModuleTotals = $studioModuleTotals;
    }

    /**
     * @return mixed
     */
    public function getMixedModuleTotals()
    {
        return $this->mixedModuleTotals;
    }

    /**
     * @param mixed $mixedModuleTotals
     */
    public function setMixedModuleTotals($mixedModuleTotals)
    {
        $this->mixedModuleTotals = $mixedModuleTotals;
    }

    /**
     * @return mixed
     */
    public function getProjectModulesUGTotals()
    {
        return $this->projectModulesUGTotals;
    }

    /**
     * @param mixed $projectModulesUGTotals
     */
    public function setProjectModulesUGTotals($projectModulesUGTotals)
    {
        $this->projectModulesUGTotals = $projectModulesUGTotals;
    }

    /**
     * @return mixed
     */
    public function getPlacementModuleTotals()
    {
        return $this->placementModuleTotals;
    }

    /**
     * @param mixed $placementModuleTotals
     */
    public function setPlacementModuleTotals($placementModuleTotals)
    {
        $this->placementModuleTotals = $placementModuleTotals;
    }

    /**
     * @return mixed
     */
    public function getProjectModulesPGTotals()
    {
        return $this->projectModulesPGTotals;
    }

    /**
     * @param mixed $projectModulesPGTotals
     */
    public function setProjectModulesPGTotals($projectModulesPGTotals)
    {
        $this->projectModulesPGTotals = $projectModulesPGTotals;
    }

    /**
     * @return mixed
     */
    public function getKtpModuleTotals()
    {
        return $this->ktpModuleTotals;
    }

    /**
     * @param mixed $ktpModuleTotals
     */
    public function setKtpModuleTotals($ktpModuleTotals)
    {
        $this->ktpModuleTotals = $ktpModuleTotals;
    }

    /**
     * @return mixed
     */
    public function getModuleLeaderHrsTotal()
    {
        return $this->moduleLeaderHrsTotal;
    }

    /**
     * @param mixed $moduleLeaderHrsTotal
     */
    public function setModuleLeaderHrsTotal($moduleLeaderHrsTotal)
    {
        $this->moduleLeaderHrsTotal = $moduleLeaderHrsTotal;
    }

    /**
     * @return mixed
     */
    public function getInternalModeratorHrsTotal()
    {
        return $this->internalModeratorHrsTotal;
    }

    /**
     * @param mixed $internalModeratorHrsTotal
     */
    public function setInternalModeratorHrsTotal($internalModeratorHrsTotal)
    {
        $this->internalModeratorHrsTotal = $internalModeratorHrsTotal;
    }

    /**
     * @return mixed
     */
    public function getPhdAllocationTotals()
    {
        return $this->PhdAllocationTotals;
    }

    /**
     * @param mixed $PhdAllocationTotals
     */
    public function setPhdAllocationTotals($PhdAllocationTotals)
    {
        $this->PhdAllocationTotals = $PhdAllocationTotals;
    }

    /**
     * @return mixed
     */
    public function getResearchItemTotals()
    {
        return $this->researchItemTotals;
    }

    /**
     * @param mixed $researchItemTotals
     */
    public function setResearchItemTotals($researchItemTotals)
    {
        $this->researchItemTotals = $researchItemTotals;
    }

    /**
     * @return mixed
     */
    public function getTeachingRelatedItemTotals()
    {
        return $this->teachingRelatedItemTotals;
    }

    /**
     * @param mixed $teachingRelatedItemTotals
     */
    public function setTeachingRelatedItemTotals($teachingRelatedItemTotals)
    {
        $this->teachingRelatedItemTotals = $teachingRelatedItemTotals;
    }

    /**
     * @return mixed
     */
    public function getManagementItemTotals()
    {
        return $this->managementItemTotals;
    }

    /**
     * @param mixed $managementItemTotals
     */
    public function setManagementItemTotals($managementItemTotals)
    {
        $this->managementItemTotals = $managementItemTotals;
    }

    /**
     * @return mixed
     */
    public function getAdminItemTotals()
    {
        return $this->adminItemTotals;
    }

    /**
     * @param mixed $adminItemTotals
     */
    public function setAdminItemTotals($adminItemTotals)
    {
        $this->adminItemTotals = $adminItemTotals;
    }

    /**
     * @return mixed
     */
    public function getFst()
    {
        return $this->fst;
    }

    /**
     * @param mixed $fst
     */
    public function setFst($fst)
    {
        $this->fst = $fst;
    }

    /**
     * @return mixed
     */
    public function getTra()
    {
        return $this->tra;
    }

    /**
     * @param mixed $tra
     */
    public function setTra($tra)
    {
        $this->tra = $tra;
    }

    /**
     * @return mixed
     */
    public function getRe()
    {
        return $this->re;
    }

    /**
     * @param mixed $re
     */
    public function setRe($re)
    {
        $this->re = $re;
    }

    /**
     * @return mixed
     */
    public function getMgt()
    {
        return $this->mgt;
    }

    /**
     * @param mixed $mgt
     */
    public function setMgt($mgt)
    {
        $this->mgt = $mgt;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }


    /**
     * @return string
     */
    public function __toString() {
        return $this->title.' '.$this->firstname.' '.$this->surname;
    }

}

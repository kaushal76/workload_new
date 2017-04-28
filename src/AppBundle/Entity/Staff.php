<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

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
     *
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
     * @var
     * Total Hours for Formally Scheduled Teaching
     */
    protected $fst;

    /**
     * @var
     * Total Hours per week for Formally Scheduled Teaching
     */
    protected $fstwk;

    /**
     * @var
     * Total Hours for Teaching Related Activities
     */
    protected $tra;

    /**
     * @var
     * Total Hours for Research Activities
     */
    protected $re;

    /**
     * @var
     * Total Hours for Management Activities
     */
    protected $mgt;

    /**
     * @var
     * Total Hours for Administration Activities
     */
    protected $admin;

    /**
     * @var
     * Grand Total
     */
    protected $total;

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
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"fte"})
     */
    protected $contentChanged;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $empbasis;

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
    public function getFstwk()
    {
        return $this->fstwk;
    }

    /**
     * @param mixed $fstwk
     */
    public function setFstwk($fstwk)
    {
        $this->fstwk = $fstwk;
    }

    /**
     * @return string
     */
    public function getEmpbasis()
    {
        return $this->empbasis;
    }

    /**
     * @param string $empbasis
     */
    public function setEmpbasis($empbasis)
    {
        $this->empbasis = $empbasis;
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

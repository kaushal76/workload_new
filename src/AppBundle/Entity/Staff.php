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
     * Staff constructor.
     */

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
        $this->allocationsForModule = new ArrayCollection();
        $this->allocationsForPhdStudent = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getFte()
    {
        return $this->fte;
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
    /**
     * @return string
     */
    public function __toString() {
        return $this->title.' '.$this->firstname.' '.$this->surname;
    }
}

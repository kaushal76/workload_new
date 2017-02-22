<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PhdStudent
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="phd_student")
 */
class PhdStudent {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * One student one item.
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Item", inversedBy="PhdStudent")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item;

    /**
     * @ORM\Column(type="string")
     */
    protected $mode;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $totalHrs;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AllocationsForPhdStudent", mappedBy="phdStudent", cascade={"persist", "remove"})
     */

    protected $allocationsForPhdStudent;

    /**
     * PhDStudent constructor.
     */

    public function __construct()
    {
        $this->allocationsForPhdStudent = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAllocationsForPhDStudent()
    {
        return $this->allocationsForPhdStudent;
    }

    /**
     * @param mixed $allocationsForPhDStudent
     */
    public function setAllocationsForPhDStudent($allocationsForPhDStudent)
    {
        $this->allocationsForPhdStudent = $allocationsForPhDStudent;
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
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
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
    public function getTotalHrs()
    {
        return $this->totalHrs;
    }

    /**
     * @param mixed $totalHrs
     */
    public function setTotalHrs($totalHrs)
    {
        $this->totalHrs = $totalHrs;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

    /**
     * Add AllocationsForPhdStudent
     *
     * @param AllocationsForPhdStudent $allocationsForPhdStudent
     *
     * @return PhdStudent
     */
    public function addAllocationsForPhdStudent(AllocationsForPhdStudent $allocationsForPhdStudent)
    {

        $allocationsForPhdStudent->setPhdStudent($this);

        if (!$this->getAllocationsForPhDStudent()->contains($allocationsForPhdStudent)) {
            $this->allocationsForPhdStudent->add($allocationsForPhdStudent);
        }

        return $this;
    }

    /**
     * Remove allocationsforphdstudent
     *
     * @param AllocationsForPhdStudent $allocationsForPhdStudent
     */
    public function removeAllocationsForPhdStudent(AllocationsForPhdStudent $allocationsForPhdStudent)
    {
        $this->allocationsForPhdStudent->removeElement($allocationsForPhdStudent);
    }

}

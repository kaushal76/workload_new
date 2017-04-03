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
     * Staff constructor.
     */

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
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
     * @return string
     */
    public function __toString() {
        return $this->title.' '.$this->firstname.' '.$this->surname;
    }
}

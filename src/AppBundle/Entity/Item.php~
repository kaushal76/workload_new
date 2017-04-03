<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "items")
 */

class Item {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Allocation", mappedBy="item", cascade={"persist", "remove"})
     */

    protected $allocations;

    /**
     * @var string
     * @ORM\Column(type="string")
     */

    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     *
     * One optional module one item .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Module", mappedBy="item")
     */
    protected $module;

    /**
     *
     * One optional phdstudent one item .
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\phdStudent", mappedBy="item")
     */
    protected $phdstudent;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ItemCategory", inversedBy="items")
     * @ORM\JoinColumn(name="item_category", referencedColumnName="id")
     */
    protected $category;


    /**
     * Item constructor.
     */

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    /**
     * @return mixed
     */
    public function getPhdstudent()
    {
        return $this->phdstudent;
    }

    /**
     * @param mixed $phdstudent
     */
    public function setPhdstudent($phdstudent)
    {
        $this->phdstudent = $phdstudent;
    }


    /**
     * @return ItemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $allocations
     */
    public function setAllocations($allocations)
    {
        $this->allocations = $allocations;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add Allocations
     *
     * @param Allocation $allocations
     *
     * @return Item
     */
    public function addAllocation(Allocation $allocations)
    {
        $allocations->setItem($this);

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
        return $this->name;
    }

}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PreparationCategory
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="preparation_category")
 */
class PreparationCategory {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Module", mappedBy="preparationCategory", cascade={"persist"})
     */

    protected $modules;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $code;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $studioPrepHrs;

    /**
     * PreparationCategory constructor.
     */

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getStudioPrepHrs()
    {
        return $this->studioPrepHrs;
    }

    /**
     * @param float $studioPrepHrs
     */
    public function setStudioPrepHrs($studioPrepHrs)
    {
        $this->studioPrepHrs = $studioPrepHrs;
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
     * @return PreparationCategory
     */
    public function addModule(Module $module)
    {

        $module->setPreparationCategory($this);
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
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $code
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
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }
}

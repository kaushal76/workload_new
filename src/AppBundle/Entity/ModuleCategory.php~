<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ModuleCategory
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="module_category")
 */
class ModuleCategory {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Module", mappedBy="moduleCategory", cascade={"persist"})
     */

    protected $modules;

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
     * @var float
     * @ORM\Column(type="float")
     */
    protected $studioPrepHrs;


    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $contactHrsFactor;

    /**
     * ModuleCategory constructor.
     */

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getStudioPrepHrs()
    {
        return $this->studioPrepHrs;
    }

    /**
     * @param mixed $studioPrepHrs
     */
    public function setStudioPrepHrs($studioPrepHrs)
    {
        $this->studioPrepHrs = $studioPrepHrs;
    }

    /**
     * @return float
     */
    public function getContactHrsFactor()
    {
        return $this->contactHrsFactor;
    }

    /**
     * @param float $contactHrsFactor
     */
    public function setContactHrsFactor($contactHrsFactor)
    {
        $this->contactHrsFactor = $contactHrsFactor;
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
     * @return ModuleCategory
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

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AllocationsForPhdStudent
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="allocations_for_phd_student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlloactionsForPhdStudentRepository")
 */
class AllocationsForPhdStudent {


    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Staff", inversedBy="allocationsForPhdStudent")
     * @ORM\JoinColumn(name="staff", referencedColumnName="id")
     */
    protected $staff;

    /**
     *
     * @var
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PhdStudent", inversedBy="allocationsForPhdStudent")
     * @ORM\JoinColumn(name="phd_student", referencedColumnName="id")
     */
    protected $phdStudent;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $allocatedHrs;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */

    protected $supportHrs;

    /**
     * @return int
     */
    public function getStaff()
    {
        return $this->staff;
    }


    /**
     * @return int
     */
    public function getAllocatedHrs()
    {
        return $this->allocatedHrs;
    }

    /**
     * @param int $staff
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }

    /**
     * @param int $allocatedHrs
     */
    public function setAllocatedHrs($allocatedHrs)
    {
        $this->allocatedHrs = $allocatedHrs;
    }

    /**
     * @return mixed
     */
    public function getPhdStudent()
    {
        return $this->phdStudent;
    }

    /**
     * @param mixed $phdStudent
     */
    public function setPhdStudent($phdStudent)
    {
        $this->phdStudent = $phdStudent;
    }

    /**
     * @return float
     */
    public function getSupportHrs()
    {
        return $this->supportHrs;
    }

    /**
     * @param float $supportHrs
     */
    public function setSupportHrs($supportHrs)
    {
        $this->supportHrs = $supportHrs;
    }

}

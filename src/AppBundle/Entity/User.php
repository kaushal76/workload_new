<?php
/**
 * Created by PhpStorm.
 * User: sdeskpk
 * Date: 25/02/2017
 * Time: 19:25
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $name;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
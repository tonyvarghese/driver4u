<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\customer_detailsRepository")
 *
 */
class Customer
{
    
    /**
     * @ORM\OneToMany(targetEntity="Trip", mappedBy="customer")
     */
    private $trips;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=500)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $phone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usual_trip", type="string", length=500)
     */
    private $usualTrip;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_driver", type="string", length=255)
     */
    private $preferredDriver;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint",options={"default" : 0, "comment":"0:Inactive, 1:Active"})
     */
    private $status;
    
    
    public function __construct() {
        $this->trips = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getFullName()
    {
        return $this->fullName;
    }
    

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    

    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    

    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }    
    
    /**
     * Set uid
     *
     * @param integer $uid
     *
     * @return customer
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set usualTrip
     *
     * @param string $usualTrip
     *
     * @return customer
     */
    public function setUsualTrip($usualTrip)
    {
        $this->usualTrip = $usualTrip;

        return $this;
    }

    /**
     * Get usualTrip
     *
     * @return string
     */
    public function getUsualTrip()
    {
        return $this->usualTrip;
    }

    /**
     * Set preferredDriver
     *
     * @param string $preferredDriver
     *
     * @return customer
     */
    public function setPreferredDriver($preferredDriver)
    {
        $this->preferredDriver = $preferredDriver;

        return $this;
    }

    /**
     * Get preferredDriver
     *
     * @return string
     */
    public function getPreferredDriver()
    {
        return $this->preferredDriver;
    }
    

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }    
}


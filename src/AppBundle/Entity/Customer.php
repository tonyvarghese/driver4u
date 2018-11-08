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
     * @var Trip[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Trip",
     *      mappedBy="customer",
     *      orphanRemoval=true)
     */
    private $trips;
        
    /**
     * @ORM\OneToMany(targetEntity="CustomerAddress", mappedBy="userId", orphanRemoval=true)
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="CustomerVehicle", mappedBy="customerId", orphanRemoval=true)
     */
    private $vehicles;

        
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
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;


    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $phone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usual_trip", type="string", length=500, nullable=true)
     */
    private $usualTrip;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_type", type="string", nullable=true, options={"comment":"1:Monthly, 2:On Demand"})
     */
    private $customertype;

    /**
     * @var Driver
     * @ORM\ManyToOne(targetEntity="Driver")
     * @ORM\JoinColumn(name="preferred_driver", referencedColumnName="id", nullable=true)
     */
    private $preferredDriver;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint",options={"default" : 0, "comment":"0:Inactive, 1:Active"})
     */
    private $status;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime" )
     */
    private $createdAt;    
    
    
    public function __construct() {
        $this->trips = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
    }
    
    public function getTrips()
    {
        return $this->trips;
    }     
    
    public function getVehicles()
    {
        return $this->vehicles;
    }      
    
    public function removeVehicle(CustomerVehicle $vehicle)
    {
        $vehicle->setCustomer(null);
        $this->vehicles->removeElement($vehicle);
    }    
    
    public function getAddresses()
    {
        return $this->addresses;
    }      
    
    public function removeAddress(CustomerAddress $address)
    {
        $address->setCustomer(null);
        $this->addresses->removeElement($address);
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

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;

    }

    public function getLocation()
    {
        return $this->location;
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
     * @return driver
     */
    public function setPreferredDriver(Driver $preferredDriver)
    {
        $this->preferredDriver = $preferredDriver;

        return $this;
    }


    /**
     * Get preferredDriver
     *
     * @return Driver
     */
    public function getPreferredDriver()
    {
        return $this->preferredDriver;
    }

    /**
     * Set customerType
     *
     * @param string $customertype
     *
     * @return Customer
     */
    public function setCustomerType($customertype)
    {
        $this->customertype = $customertype;

        return $this;
    }

    /**
     * Get $customertype
     *
     * @return string
     */
    public function getCustomerType()
    {
        return $this->customertype;
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
    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Lead
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }    
}


<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Driver
 *
 * @ORM\Table(name="drivers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriversRepository")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Driver
{
    

   /**
     * @var Trip[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Trip",
     *      mappedBy="driver",
     *      orphanRemoval=true)
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
     * @Assert\NotBlank()
     * @ORM\Column(name="full_name", type="string", length=500)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=500)
     */
    private $address;


    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", length=20, nullable=true)
     */
    private $age;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="doj", type="datetime", options={"comment":"Date of Joining"})
     */
    private $doj;
    
    /**
     * @var string
     *
     * @ORM\Column(name="driver_type", type="string", options={"comment":"1:Full Time, 2:Part Time"})
     */
    private $driverType;

    /**
     * @var string
     *
     * @ORM\Column(name="expertise", type="string", options={"comment":"1:Manual, 2:Automatic, 3:Premium"})
     */
    private $expertise;

    /**
     * @var int
     *
     * @ORM\Column(name="pcc_submitted", type="integer", options={"comment":"0 for no, 1 for yes"})
     */
    private $pccSubmitted;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", nullable=true, options={"comment":"1:Driving Licence, 2:Pan Card, 3:Aadhar"})
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_number", type="string", length=255, unique=true, nullable=true)
     */
    private $docNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="driver_assignment", type="string", options={"comment":"1:Monthly, 2:On Demand"})
     */
    private $driverAssignment;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable = true)
     */
    private $note;

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
    }
    
    public function getTrips()
    {
        return $this->trips;
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
     * @param string $fullname
     */
    public function setFullName($fullname)
    {
        $this->fullName = $fullname;
        return $this;

    }

    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return string
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
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


    /**
     * Set address
     *
     * @param string $address
     *
     * @return string
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;

    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return string
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;

    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Driver
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }


    /**
     * Set driverType
     *
     * @param string $driverType
     *
     * @return Driver
     */
    public function setDriverType($driverType)
    {
        $this->driverType = $driverType;

        return $this;
    }

    /**
     * Get driverType
     *
     * @return string
     */
    public function getDriverType()
    {
        return $this->driverType;
    }

    /**
     * Set expertise
     *
     * @param string $expertise
     *
     * @return Driver
     */
    public function setExpertise($expertise)
    {
        $this->expertise = $expertise;

        return $this;
    }

    /**
     * Get expertise
     *
     * @return string
     */
    public function getExpertise()
    {
        return $this->expertise;
    }

    /**
     * Set pccSubmitted
     *
     * @param integer $pccSubmitted
     *
     * @return Driver
     */
    public function setPccSubmitted($pccSubmitted)
    {
        $this->pccSubmitted = $pccSubmitted;

        return $this;
    }

    /**
     * Get pccSubmitted
     *
     * @return int
     */
    public function getPccSubmitted()
    {
        return $this->pccSubmitted;
    }

    /**
     * Set document
     *
     * @param string $document
     *
     * @return Driver
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set docNumber
     *
     * @param string $docNumber
     *
     * @return Driver
     */
    public function setDocNumber($docNumber)
    {
        $this->docNumber = $docNumber;

        return $this;
    }

    /**
     * Get docNumber
     *
     * @return string
     */
    public function getDocNumber()
    {
        return $this->docNumber;
    }

    /**
     * Set driverAssignment
     *
     * @param integer $driverAssignment
     *
     * @return Driver
     */
    public function setDriverAssignment($driverAssignment)
    {
        $this->driverAssignment = $driverAssignment;

        return $this;
    }

    /**
     * Get driverAssignment
     *
     * @return string
     */
    public function getDriverAssignment()
    {
        return $this->driverAssignment;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Driver
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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
    

    /**
     * Set DOJ
     *
     * @param \DateTime $doj
     *
     * @return Driver
     */
    public function setDoj($doj)
    {
        $this->doj = $doj;

        return $this;
    }

    /**
     * Get doj
     *
     * @return \DateTime
     */
    public function getDoj()
    {
        return $this->doj;
    }        
}
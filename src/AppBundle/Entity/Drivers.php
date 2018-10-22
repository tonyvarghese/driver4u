<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drivers
 *
 * @ORM\Table(name="drivers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriversRepository")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Drivers
{
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
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;


    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", length=20, nullable=true)
     */


    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="driver_type", type="integer", options={"comment":"1:Full Time, 2:Part Time"})
     */
    private $driverType;

    /**
     * @var int
     *
     * @ORM\Column(name="expertise", type="integer", options={"comment":"1:Manual, 2:Automatic, 3:Premium"})
     */
    private $expertise;

    /**
     * @var int
     *
     * @ORM\Column(name="pcc_submitted", type="integer", options={"comment":"0 for no, 1 for yes"})
     */
    private $pccSubmitted;

    /**
     * @var int
     *
     * @ORM\Column(name="document", type="integer", nullable=true, options={"comment":"1:Driving Licence, 2:Pan Card, 3:Aadhar"})
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_number", type="string", length=255, unique=true, nullable=true)
     */
    private $docNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="driver_assignment", type="integer", options={"comment":"1:Monthly, 2:On Demand"})
     */
    private $driverAssignment;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable = true)
     */
    private $note;


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
     * @return Drivers
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
     * @param integer $driverType
     *
     * @return Drivers
     */
    public function setDriverType($driverType)
    {
        $this->driverType = $driverType;

        return $this;
    }

    /**
     * Get driverType
     *
     * @return int
     */
    public function getDriverType()
    {
        return $this->driverType;
    }

    /**
     * Set expertise
     *
     * @param integer $expertise
     *
     * @return Drivers
     */
    public function setExpertise($expertise)
    {
        $this->expertise = $expertise;

        return $this;
    }

    /**
     * Get expertise
     *
     * @return int
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
     * @return Drivers
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
     * @param integer $document
     *
     * @return Drivers
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return int
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
     * @return Drivers
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
     * @return Drivers
     */
    public function setDriverAssignment($driverAssignment)
    {
        $this->driverAssignment = $driverAssignment;

        return $this;
    }

    /**
     * Get driverAssignment
     *
     * @return int
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
     * @return Drivers
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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

}


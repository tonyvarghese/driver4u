<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DriverDetails
 *
 * @ORM\Table(name="driver_details",indexes={@ORM\Index(name="index_uid", columns={"uid"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriverDetailsRepository")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class DriverDetails
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
     * @var int
     * @ORM\Column(name="uid", type="integer")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="DriverDetails")
     * @ORM\JoinColumn(name="uid", referencedColumnName="id")
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

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
     * @ORM\Column(name="driver_assignment", type="integer",options={"comment":"1:Monthly, 2:On Demand"})
     */
    private $driverAssignment;

    /**
     * @var string
     *
     * @ORM\Column(name="drawback", type="text", nullable=true)
     */
    private $drawback;


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
     * Set uid
     *
     * @param integer $uid
     *
     * @return DriverDetails
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
     * Set location
     *
     * @param string $location
     *
     * @return DriverDetails
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set driverType
     *
     * @param integer $driverType
     *
     * @return DriverDetails
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
     * @return DriverDetails
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
     * @return DriverDetails
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
     * @return DriverDetails
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
     * @return DriverDetails
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
     * @return DriverDetails
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
     * Set drawback
     *
     * @param string $drawback
     *
     * @return DriverDetails
     */
    public function setDrawback($drawback)
    {
        $this->drawback = $drawback;

        return $this;
    }

    /**
     * Get drawback
     *
     * @return string
     */
    public function getDrawback()
    {
        return $this->drawback;
    }
}


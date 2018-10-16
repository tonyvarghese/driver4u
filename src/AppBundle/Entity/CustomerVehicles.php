<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * customerVehicles
 *
 * @ORM\Table(name="customer_vehicles",indexes={@ORM\Index(name="index_customer_id", columns={"customer_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerVehiclesRepository")
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CustomerVehicles
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\ManyToOne(targetEntity="CustomerDetails", inversedBy="CustomerVehicles")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="customer_id", type="integer")
     */
    private $customerId;

    /**
     * @var int
     *
     * @ORM\Column(name="reg_number", type="integer", nullable=true)
     */
    private $regNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="vehicle_model", type="string", length=255, nullable=true)
     */
    private $vehicleModel;

    /**
     * @var int
     *
     * @ORM\Column(name="vehicle_type", type="integer")
     */
    private $vehicleType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


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
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return CustomerVehicles
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set regNumber
     *
     * @param integer $regNumber
     *
     * @return CustomerVehicles
     */
    public function setRegNumber($regNumber)
    {
        $this->regNumber = $regNumber;

        return $this;
    }

    /**
     * Get regNumber
     *
     * @return int
     */
    public function getRegNumber()
    {
        return $this->regNumber;
    }

    /**
     * Set vehicleModel
     *
     * @param string $vehicleModel
     *
     * @return CustomerVehicles
     */
    public function setVehicleModel($vehicleModel)
    {
        $this->vehicleModel = $vehicleModel;

        return $this;
    }

    /**
     * Get vehicleModel
     *
     * @return string
     */
    public function getVehicleModel()
    {
        return $this->vehicleModel;
    }

    /**
     * Set vehicleType
     *
     * @param integer $vehicleType
     *
     * @return CustomerVehicles
     */
    public function setVehicleType($vehicleType)
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    /**
     * Get vehicleType
     *
     * @return int
     */
    public function getVehicleType()
    {
        return $this->vehicleType;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CustomerVehicles
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return CustomerVehicles
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }


}


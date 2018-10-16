<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TripSchedule
 *
 * @ORM\Table(name="trip_schedule",indexes={@ORM\Index(name="index_cust_id", columns={"customer_id"}), @ORM\Index(name="index_driver_id", columns={"driver_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TripScheduleRepository")
 */
class TripSchedule
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
     *
     * @ORM\Column(name="customer_id", type="integer")
     */
    private $customerId;

    /**
     * @var int
     *
     * @ORM\Column(name="driver_id", type="integer")
     */
    private $driverId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="trip_time", type="datetime")
     */
    private $tripTime;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * @var int
     *
     * @ORM\Column(name="discount", type="integer")
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(name="vehicle_id", type="integer")
     */
    private $vehicleId;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint",options={"comment":"1:Scheduled, 2:Completed, 3:Cancelled"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="text")
     */
    private $feedback;

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
     * @return TripSchedule
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
     * Set driverId
     *
     * @param integer $driverId
     *
     * @return TripSchedule
     */
    public function setDriverId($driverId)
    {
        $this->driverId = $driverId;

        return $this;
    }

    /**
     * Get driverId
     *
     * @return int
     */
    public function getDriverId()
    {
        return $this->driverId;
    }

    /**
     * Set tripTime
     *
     * @param \DateTime $tripTime
     *
     * @return TripSchedule
     */
    public function setTripTime($tripTime)
    {
        $this->tripTime = $tripTime;

        return $this;
    }

    /**
     * Get tripTime
     *
     * @return \DateTime
     */
    public function getTripTime()
    {
        return $this->tripTime;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return TripSchedule
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return TripSchedule
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set vehicleId
     *
     * @param integer $vehicleId
     *
     * @return TripSchedule
     */
    public function setVehicleId($vehicleId)
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    /**
     * Get vehicleId
     *
     * @return int
     */
    public function getVehicleId()
    {
        return $this->vehicleId;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return TripSchedule
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set feedback
     *
     * @param string $feedback
     *
     * @return TripSchedule
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback
     *
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TripSchedule
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
     * @return TripSchedule
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
}


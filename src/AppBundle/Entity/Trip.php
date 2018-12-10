<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trips
 *
 * @ORM\Table(name="trips",indexes={@ORM\Index(name="index_cust_id", columns={"customer_id"}), @ORM\Index(name="index_driver_id", columns={"driver_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TripScheduleRepository")
 */
class Trip
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
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;    

    /**
     * @var Driver
     *
     * @ORM\ManyToOne(targetEntity="Driver", inversedBy="trips")
     * @ORM\JoinColumn(nullable=true)
     */
    private $driver;    
    
    
    /**
     * @var CustomerVehicle
     *
     * @ORM\Column(name="vehicle_id", type="integer", nullable=true)
     */
    private $vehicle;   
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_time", type="datetime")
     */
    private $scheduledTime;

    /**
     * @var location
     *
     * @ORM\Column(name="location", type="string", nullable=true)
     */
    private $location;
    
    /**
     * @var int
     *
     * @ORM\Column(name="rate", nullable=true, type="integer",options={"default" : 0})
     */
    private $rate;

    /**
     * @var int
     *
     * @ORM\Column(name="discount", nullable=true, type="integer",options={"default" : 0})
     */
    private $discount;


    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint",options={"comment":"1:Scheduled, 2:In Progress, 3:Completed, 4:Cancelled"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="text", nullable=true)
     */
    private $feedback;

    /**
     * @var string
     *
     * @ORM\Column(name="cancelled_by", type="string", nullable=true)
     */
    private $cancelledBy;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="cancel_reason", type="text", nullable=true)
     */
    private $cancelReason;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_time", type="datetime", nullable=true)
     */
    private $startedTime;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended_time", type="datetime", nullable=true)
     */
    private $endedTime;    
    

    /**
     * @var int
     *
     * @ORM\Column(name="amount_collected", type="smallint",options={"default" : 0})
     */
    private $amountCollected;    
    

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

    
    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }
     
    public function getDriver()
    {
        return $this->driver;
    }

    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Set scheduledTime
     *
     * @param \DateTime $scheduledTime
     *
     * @return Trip
     */
    public function setScheduledTime($scheduledTime)
    {
        $this->scheduledTime = $scheduledTime;

        return $this;
    }

    /**
     * Get scheduledTime
     *
     * @return \DateTime
     */
    public function getScheduledTime()
    {
        return $this->scheduledTime;
    }


    /**
     * Set location
     *
     * @param string $location
     *
     * @return Trip
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
     * Set rate
     *
     * @param integer $rate
     *
     * @return Trip
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
     * @return Trip
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

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Trip
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
     * @return Trip
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
     * Set startedTime
     *
     * @param string $startedTime
     *
     * @return Trip
     */
    public function setStartedTime($startedTime)
    {
        $this->startedTime = $startedTime;

        return $this;
    }

    /**
     * Get startedTime
     *
     * @return string
     */
    public function getStartedTime()
    {
        return $this->startedTime;
    }
    

    /**
     * Set endedTime
     *
     * @param string $endedTime
     *
     * @return Trip
     */
    public function setEndedTime($endedTime)
    {
        $this->endedTime = $endedTime;

        return $this;
    }

    /**
     * Get endedTime
     *
     * @return string
     */
    public function getEndedTime()
    {
        return $this->endedTime;
    }

     /**
     * Set amountCollected
     *
     * @param string $amountCollected
     *
     * @return Trip
     */
    public function setAmountCollected($amountCollected)
    {
        $this->amountCollected = $amountCollected;

        return $this;
    }

    /**
     * Get amountCollected
     *
     * @return string
     */
    public function getAmountCollected()
    {
        return $this->amountCollected;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Trip
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
     * @return Trip
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
     * Set cancelledBy
     *
     * @param int $cancelledBy
     *
     * @return Trip
     */
    public function setCancelledBy($cancelledBy)
    {
        $this->cancelledBy = $cancelledBy;

        return $this;
    }

    /**
     * Get cancelledBy
     *
     * @return int
     */
    public function getCancelledBy()
    {
        return $this->cancelledBy;
    }    
    

    /**
     * Set cancelReason
     *
     * @param string $cancelReason
     *
     * @return Trip
     */
    public function setCancelReason($cancelReason) {
        $this->cancelReason = $cancelReason;

        return $this;
    }

    /**
     * Get cancelReason
     *
     * @return string
     */
    public function getCancelReason() {
        return $this->cancelReason;
    }


    
}


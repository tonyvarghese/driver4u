<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TripLogs
 *
 * @ORM\Table(name="trip_logs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TripLogsRepository")
 */
class TripLogs
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
     * @ORM\Column(name="trip_id", type="integer",unique=true)
     */
    private $tripId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime")
     */
    private $endTime;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_collected", type="smallint")
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
     * Set tripId
     *
     * @param integer $tripId
     *
     * @return TripLogs
     */
    public function setTripId($tripId)
    {
        $this->tripId = $tripId;

        return $this;
    }

    /**
     * Get tripId
     *
     * @return int
     */
    public function getTripId()
    {
        return $this->tripId;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return TripLogs
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return TripLogs
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set amountCollected
     *
     * @param integer $amountCollected
     *
     * @return TripLogs
     */
    public function setAmountCollected($amountCollected)
    {
        $this->amountCollected = $amountCollected;

        return $this;
    }

    /**
     * Get amountCollected
     *
     * @return int
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
     * @return TripLogs
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
     * @return TripLogs
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


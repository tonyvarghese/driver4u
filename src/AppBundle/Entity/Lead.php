<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Leads
 *
 * @ORM\Table(name="leads")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeadsRepository")
 */
class Lead
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
     * @Assert\NotBlank()
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;
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
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="location", type="string", length=255,)
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint",options={"comment":"1:Interested, 2:Not interested, 3:Cancelled"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="string", length=255, nullable=true)
     */
    private $feedback;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="followup_date", type="datetime", nullable=true)
     */
    private $followupDate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime" )
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
     * Set name
     *
     * @param string $fullname
     *
     * @return Lead
     */
    public function setFullName($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullname;
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
     * @return Lead
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
     * Set location
     *
     * @param string $location
     *
     * @return Lead
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
     * Set location
     *
     * @param string $feedback
     *
     * @return Lead
     */
    public function setFeedback($feedback)
    {
        $this->feedback= $feedback;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }



    /**
     * Set status
     *
     * @param integer $status
     *
     * @return int
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
     * Set followupDate
     *
     * @param \DateTime $followupDate
     *
     * @return Lead
     */
    public function setFollowupDate($followupDate)
    {
        $this->followupDate = $followupDate;

        return $this;
    }

    /**
     * Get followupDate
     *
     * @return \DateTime
     */
    public function getFollowupDate()
    {
        return $this->followupDate;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Lead
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


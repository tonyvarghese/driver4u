<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeadFollowup
 *
 * @ORM\Table(name="lead_followup",indexes={@ORM\Index(name="index_leadid", columns={"lead_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeadFollowupRepository")
 */
class LeadFollowup
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
     * @ORM\Column(name="lead_id", type="integer")
     */
    private $leadId;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="string", length=255)
     */
    private $feedback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_followup", type="datetime")
     */
    private $nextFollowup;

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
     * Set leadId
     *
     * @param integer $leadId
     *
     * @return LeadFollowup
     */
    public function setLeadId($leadId)
    {
        $this->leadId = $leadId;

        return $this;
    }

    /**
     * Get leadId
     *
     * @return int
     */
    public function getLeadId()
    {
        return $this->leadId;
    }

    /**
     * Set feedback
     *
     * @param string $feedback
     *
     * @return LeadFollowup
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
     * Set nextFollowup
     *
     * @param \DateTime $nextFollowup
     *
     * @return LeadFollowup
     */
    public function setNextFollowup($nextFollowup)
    {
        $this->nextFollowup = $nextFollowup;

        return $this;
    }

    /**
     * Get nextFollowup
     *
     * @return \DateTime
     */
    public function getNextFollowup()
    {
        return $this->nextFollowup;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LeadFollowup
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
     * @return LeadFollowup
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


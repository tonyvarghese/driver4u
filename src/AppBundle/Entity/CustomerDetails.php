<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * customerDetails
 *
 * @ORM\Table(name="customer_details")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\customer_detailsRepository")
 *
 */
class CustomerDetails
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
     * @ORM\Column(name="uid", type="integer")
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="usual_trip", type="string", length=500)
     */
    private $usualTrip;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_driver", type="string", length=255)
     */
    private $preferredDriver;


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
     * @return customerDetails
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
     * @return customerDetails
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
     * Set usualTrip
     *
     * @param string $usualTrip
     *
     * @return customerDetails
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
     * @return customerDetails
     */
    public function setPreferredDriver($preferredDriver)
    {
        $this->preferredDriver = $preferredDriver;

        return $this;
    }

    /**
     * Get preferredDriver
     *
     * @return string
     */
    public function getPreferredDriver()
    {
        return $this->preferredDriver;
    }
}


<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContactNos
 *
 * @ORM\Table(name="user_contact_nos",indexes={@ORM\Index(name="index_uid", columns={"uid"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserContactNosRepository")
 */
class UserContactNos
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
     * @ORM\Column(name="contact_number", type="string", length=255)
     */
    private $contactNumber;


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
     * @return UserContactNos
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
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return UserContactNos
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }
}


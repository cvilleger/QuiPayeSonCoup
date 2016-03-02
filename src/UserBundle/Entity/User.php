<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="pictureName", type="string", length=255, nullable=true, unique=true)
     */
    private $pictureName;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Room", mappedBy="administrator", cascade={"remove", "persist"})
     */
    protected $roomsAdmin;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Room", inversedBy="users")
     */
    protected $rooms;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invitation", mappedBy="user", cascade={"remove", "persist"})
     */
    protected $userInvitations;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set pictureName
     *
     * @param string $pictureName
     * @return User
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string 
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * Add rooms
     *
     * @param \AppBundle\Entity\Room $rooms
     * @return User
     */
    public function addRoom(\AppBundle\Entity\Room $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \AppBundle\Entity\Room $rooms
     */
    public function removeRoom(\AppBundle\Entity\Room $rooms)
    {
        $this->rooms->removeElement($rooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Get room
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Add userInvitations
     *
     * @param \AppBundle\Entity\Invitation $userInvitations
     * @return User
     */
    public function addUserInvitation(\AppBundle\Entity\Invitation $userInvitations)
    {
        $this->userInvitations[] = $userInvitations;

        return $this;
    }

    /**
     * Remove userInvitations
     *
     * @param \AppBundle\Entity\Invitation $userInvitations
     */
    public function removeUserInvitation(\AppBundle\Entity\Invitation $userInvitations)
    {
        $this->userInvitations->removeElement($userInvitations);
    }

    /**
     * Get userInvitations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserInvitations()
    {
        return $this->userInvitations;
    }
}

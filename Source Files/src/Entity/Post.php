<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="fk_post_user_has_location1_idx", columns={"user_has_location_user_id", "user_has_location_location_id"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=450, precision=0, scale=0, nullable=false, unique=false)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $date;

    /**
     * @var \Travel\Entity\UserHasLocation
     *
     * @ORM\ManyToOne(targetEntity="Travel\Entity\UserHasLocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_has_location_user_id", referencedColumnName="user_id", nullable=true),
     *   @ORM\JoinColumn(name="user_has_location_location_id", referencedColumnName="location_id", nullable=true)
     * })
     */
    private $userHasLocationUser;


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
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Post
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userHasLocationUser
     *
     * @param \Travel\Entity\UserHasLocation $userHasLocationUser
     * @return Post
     */
    public function setUserHasLocationUser(\Travel\Entity\UserHasLocation $userHasLocationUser = null)
    {
        $this->userHasLocationUser = $userHasLocationUser;

        return $this;
    }

    /**
     * Get userHasLocationUser
     *
     * @return \Travel\Entity\UserHasLocation 
     */
    public function getUserHasLocationUser()
    {
        return $this->userHasLocationUser;
    }
}

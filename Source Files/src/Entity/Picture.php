<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture", indexes={@ORM\Index(name="fk_picture_post_idx", columns={"post_id"})})
 * @ORM\Entity
 */
class Picture
{

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Travel\Entity\Post", inversedBy="pictures")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;


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
     * @ORM\Column(name="name", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=300, precision=0, scale=0, nullable=true, unique=false)
     */
    private $filename;

    // /**
    //  * @var \Travel\Entity\Post
    //  *
    //  * @ORM\ManyToOne(targetEntity="Travel\Entity\Post")
    //  * @ORM\JoinColumns({
    //  *   @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=true)
    //  * })
    //  */
    // private $post;   


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
     * Set name
     *
     * @param string $name
     * @return Picture
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Picture
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set post
     *
     * @param \Travel\Entity\Post $post
     * @return Picture
     */
    public function setPost(\Travel\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Travel\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}

<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="picture")
 */
class Picture
{
    /**
     * @var integer
     *
     * @ORM\Column(name="picture_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pictureId;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_name", type="string", length=45, nullable=false)
     */
    private $pictureName;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_filename", type="string", length=45, nullable=false)
     */
    private $pictureFilename;

    /**
     * Many Features have One Product.
     * @ManyToOne(targetEntity="Post", inversedBy="pictures")
     * @JoinColumn(name="post_fk", referencedColumnName="post_id")
     */
    private $post;

    /**
     * @return int
     */
    public function getPictureId(): int
    {
        return $this->pictureId;
    }

    /**
     * @param int $pictureId
     */
    public function setPictureId(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @return string
     */
    public function getPictureName(): string
    {
        return $this->pictureName;
    }

    /**
     * @param string $pictureName
     */
    public function setPictureName(string $pictureName)
    {
        $this->pictureName = $pictureName;
    }

    /**
     * @return string
     */
    public function getPictureFilename(): string
    {
        return $this->pictureFilename;
    }

    /**
     * @param string $pictureFilename
     */
    public function setPictureFilename(string $pictureFilename)
    {
        $this->pictureFilename = $pictureFilename;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }
}
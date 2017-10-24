<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="post_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postId;

    /**
     * @var string
     *
     * @ORM\Column(name="post_date", type="string", length=45, nullable=false)
     */
    private $postDate;

    /**
     * @var string
     *
     * @ORM\Column(name="post_title", type="string", length=45, nullable=false)
     */
    private $postTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="post_text", type="string", length=45, nullable=false)
     */
    private $postText;

    /**
     * One Post has Many Pictures.
     * @OneToMany(targetEntity="Pictures", mappedBy="post")
     */
    private $pictures;



    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     */
    public function setPostId(int $postId)
    {
        $this->postId = $postId;
    }

    /**
     * @return string
     */
    public function getPostDate(): string
    {
        return $this->postDate;
    }

    /**
     * @param string $postDate
     */
    public function setPostDate(string $postDate)
    {
        $this->postDate = $postDate;
    }

    /**
     * @return string
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * @param string $postTitle
     */
    public function setPostTitle(string $postTitle)
    {
        $this->postTitle = $postTitle;
    }

    /**
     * @return string
     */
    public function getPostText(): string
    {
        return $this->postText;
    }

    /**
     * @param string $postText
     */
    public function setPostText(string $postText)
    {
        $this->postText = $postText;
    }


    public function __construct() {
        $this->pictures = new ArrayCollection();
    }
}
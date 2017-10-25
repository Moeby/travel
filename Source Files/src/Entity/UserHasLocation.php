<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasLocation
 *
 * @ORM\Table(name="user_has_location", indexes={@ORM\Index(name="fk_user_has_location_location1_idx", columns={"location_id"}), @ORM\Index(name="fk_user_has_location_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_user_has_location_post1_idx", columns={"post_id"})})
 * @ORM\Entity
 */
class UserHasLocation
{
    /**
     * @var \Location
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}

<?php
/**
 * Created by PhpStorm.
 * User: Nadja
 * Date: 24.10.2017
 * Time: 16:31
 */

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 * @ORM\Entity
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $locationId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=7, nullable=false)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=9, nullable=false)
     */
    private $longitude;
}
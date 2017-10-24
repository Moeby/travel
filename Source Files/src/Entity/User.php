<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=60, nullable=false)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_salt", type="string", length=4, nullable=false)
     */
    private $userSalt;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword(string $userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return string
     */
    public function getUserSalt(): string
    {
        return $this->userSalt;
    }

    /**
     * @param string $userSalt
     */
    public function setUserSalt(string $userSalt)
    {
        $this->userSalt = $userSalt;
    }
}
<?php

namespace Travel\Controller;

use Travel\Entity\User;

require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";

abstract class Controller
{
    /**
     * Connect to database and configure connection for Entity Manager object
     *
     * @return the configured Entity Manager object
     */
    public function getEntityManager()
    {
        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => DBUSER,
            'password' => DBPWD,
            'dbname' => DBNAME,
        );

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            ['src/Entity'],
            true,
            'C:\tmp\cache',
            null,
            false
        );
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => DBUSER,
            'password' => DBPWD,
            'dbname' => DBNAME,
        );
        $em = \Doctrine\ORM\EntityManager::create($dbParams, $config);

        return $em;
    }

    /**
     * Get the currently logged in user from the username saved in the session
     *
     * @return the currently logged in User
     */
    public function getCurrentUser(): User
    {
        $em = $this->getEntityManager();
        $username = $_SESSION['user'];
        $user = $em->getRepository('Travel\Entity\User')->findOneBy(['username' => $username]);

        return $user;
    }

}
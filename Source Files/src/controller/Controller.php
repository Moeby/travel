<?php
namespace Travel\Controller;
session_start();

use Travel\Entity\User;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";

abstract class Controller
{

    public function getEntityManager()
    {
        $paths = array($_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/src/Entity");
        $isDevMode = true;

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
            'C:\tmp\cache',//__DIR__ . '../cache/proxies',
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

}
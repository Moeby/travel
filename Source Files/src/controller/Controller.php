<?php

use Travel\Entity\User;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";

abstract class Controller
{
    public $html;

    public function __construct()
    {
        //DB Class hinzufügen

        require_once(__DIR__ . '/../../app/config/constants.php');
        // für DB-Connect
        require_once(__DIR__ . '/../../app/config/dbConfig.php');
        $this->html = file_get_contents(RESOURCE_ROOT . "view/template.html");

        //TODO: check if user logged in, otherwise show this page
        //$htmlLogin = file_get_contents(RESOURCE_ROOT ."view/templateLogin.html");
    }

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
            __DIR__ . '../cache/proxies',
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
<?php

namespace Travel\DirectCall;
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";

//*********************************************************************************
// Set up entity manager
//*********************************************************************************
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

//*********************************************************************************
// Get all locations for user
//*********************************************************************************
$user = $em->getRepository('Travel\Entity\User')->findOneBy(array("username" => $_SESSION['user']));
$locations = $user->getLocation();
$locationArray = array();

foreach ($locations as $location) {
    $locationInformation = array();
    $locationInformation[] = array("name" => $location->getName(), "latitude" => $location->getLatitude(), "longitude" => $location->getLongitude());
    $locationArray[] = array("location" => $locationInformation);
}
print json_encode($locationArray);
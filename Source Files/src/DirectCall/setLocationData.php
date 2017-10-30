<?php

namespace Travel\DirectCall;
session_start();

use DateTime;
use Travel\Entity\User;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

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

$location_exists = $em->getRepository('Travel\Entity\Location')->findOneBy(array('name' => $_POST['locationName'], 'latitude' => $_POST['lat'], 'longitude' => $_POST['lng']));

if (!empty($location_exists)) {
    $newLocation = $location_exists;
} else {
    $newLocation = new \Travel\Entity\Location();
    $newLocation->setLatitude($_POST['lat']);
    $newLocation->setLongitude($_POST['lng']);
    $newLocation->setName($_POST['adress']);
    $em->persist($newLocation);
    $em->flush();
}

$date = new DateTime();
$newPost = new \Travel\Entity\Post();
$newPost->setDate($date);
$newPost->setText("");
$newPost->setTitle($_POST['address']);

$em->persist($newPost);
$em->flush();

$userHasLocation = new \Travel\Entity\UserHasLocation();
$userHasLocation->setLocation($newLocation);
$userHasLocation->setUser($user);
$userHasLocation->setPost($newPost);
$userHasLocation->setHome(false);

$em->persist($userHasLocation);
$em->flush();

echo $newPost->getId();
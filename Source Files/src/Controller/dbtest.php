<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Travel\Entity\User;

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

/*
$newUser = new User();
$newUser->setUsername("max");
$newUser->setPassword("geheim");
$newUser->setSalt("salty");

$em->persist($newUser);
$em->flush();

$newLocation = new \Travel\Entity\Location();
$newLocation->setLatitude("12345");
$newLocation->setLongitude("12345");
$newLocation->setName("Basel");

$em->persist($newLocation);
$em->flush();

$date = new DateTime();
$newPost = new \Travel\Entity\Post();
$newPost->setDate($date);
$newPost->setText("test");
$newPost->setTitle("a very important title");

$em->persist($newPost);
$em->flush();

$userHasLocation = new \Travel\Entity\UserHasLocation();
$userHasLocation->setLocation($newLocation);
$userHasLocation->setUser($newUser);
$userHasLocation->setPost($newPost);

$em->persist($userHasLocation);
$em->flush();

*/

$xxx = $em->getRepository('Travel\Entity\User')->findOneBy(array("id" => 6));
$yyy =$xxx->getLocation();

foreach ($yyy as $location){
   // var_dump($location->getName());
    $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $xxx, "location" => $location));
    var_dump($userHasLocation->getPost()->getTitle());
}
exit;
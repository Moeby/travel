<?php

// get constant frames to "initialize" the webpage
global $html;
$html = file_get_contents("../app/resources/view/template.html");

//require_once('model/dbConnection/DB.php');
//$db = new DB();

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
} else {
    $controller = 'StartPage';
    $action     = 'home';
}

require_once('../app/config/route.php');
$html = str_replace("{{resourceRoot}}", RESOURCE_ROOT, $html);

echo $html;
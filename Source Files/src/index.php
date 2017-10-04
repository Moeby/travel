<?php

// get constant frames to "initialize" the webpage
$html = file_get_contents("../app/resources/view/template.html");
$header = '';
$nav = '';
$footer = '';

/*
$header = file_get_contents("view/frames/header.html");
$nav = file_get_contents("view/frames/nav.html");
$footer = file_get_contents("view/frames/footer.html");
*/

$html = str_replace("{{header}}", $header, $html);
$html = str_replace("{{nav}}", $nav, $html);
$html = str_replace("{{footer}}", $footer, $html);

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

echo $html;
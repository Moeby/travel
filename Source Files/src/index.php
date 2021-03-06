<?php
session_start();
require_once('../app/config/constants.php');

// get constant frames to "initialize" the webpage
global $html;
if (isset($_SESSION['user'])) {
    $html = file_get_contents("../app/resources/view/template.html");
} else {
    $html = file_get_contents("../app/resources/view/templateLogin.html");
}
$html = str_replace("{{goToResource}}", '../app/resources/', $html);


if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'Login';
    $action = 'loginAction';
}

require_once('../app/config/route.php');

echo $html;
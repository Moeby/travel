<?php

namespace Travel\Controller;
// we're adding an entry for the new controller and its actions
//@hint: Look into reflections to have less manual work
$actions = [
    'LoginCheck' => ['checkLoginAction'],
    'SignUp' => ['signUpAction', 'registerAction'],
    'Login' => ['loginAction'],
    'Post' => ['addPostAction', 'showPostsAction'],
];
/*var_dump( array_key_exists($controller, $actions)  );
echo  ' and ';
var_dump( in_array($action, $actions[$controller]) );*/
if (array_key_exists($controller, $actions) && in_array($action, $actions[$controller])) {
    $html = call($controller, $action, $html);
} else {
    require_once(__DIR__ . '/../../app/config/constants.php');
    $html = str_replace("{{pageTitle}}", "Error Page", $html);
    $html = str_replace("{{pageContent}}", "wrong action", $html);
}
$html = templateCleaner($html);

function templateCleaner($html)
{
    $html = str_replace("{{username}}", "stranger", $html);
    return $html;
}

function call($controller, $action, $html)
{
    //require_once(__DIR__.'\\..\\..\\src\\controller\\' . $controller . 'controller.php');
    require_once(ROOTPATH . 'Source Files/src/controller/Controller.php');
    require_once(ROOTPATH . 'Source Files/src/controller/' . $controller . 'Controller.php');

    //@hint: Look into reflections to have less manual work
    switch ($controller) {
        case 'SignUp':
            $controller = new SignUpController();
            break;
        case 'Login':
            $controller = new LoginController();
            echo 'login';
            break;
        case 'Post':
            $controller = new PostController();
            break;
    }
    $html = $controller->$action($html);

    return $html;
}

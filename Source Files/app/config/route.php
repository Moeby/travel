<?php

namespace Travel\Controller;

$actions = [
    'SignUp' => ['signUpAction', 'registerAction'],
    'Login'  => ['loginAction', 'checkUserAction'],
    'Post'   => ['showAddPostAction', 'showPostsAction', 'addPostAction','editPostAction', 'deletePostAction'],
    'Logout' => ['logoutAction'],
    'Map'    => ['mapAction']
];

if (array_key_exists($controller, $actions) && in_array($action, $actions[$controller])) {
    $html = call($controller, $action, $html);
} else {
    require_once(__DIR__ . '/../../app/config/constants.php');
    $html = str_replace("{{pageTitle}}", "Error Page", $html);
    $html = str_replace("{{pageContent}}", "wrong action", $html);
}
function call($controller, $action, $html)
{
    require_once(ROOTPATH . 'Source Files/src/controller/Controller.php');
    require_once(ROOTPATH . 'Source Files/src/controller/' . $controller . 'Controller.php');

    //@hint: Look into reflections to have less manual work
    switch ($controller) {
        case 'SignUp':
            $controller = new SignUpController();
            break;
        case 'Login':
            $controller = new LoginController();
            break;
        case 'Post':
            $controller = new PostController();
            break;
        case 'Logout':
            $controller = new LogoutController();
            break;
        case 'Map':
            $controller = new MapController();
            break;
    }
    $html = $controller->$action($html);

    return $html;
}

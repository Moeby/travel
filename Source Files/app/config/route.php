<?php

    function call($controller, $action) {

        //require_once(__DIR__.'\\..\\..\\src\\controller\\' . $controller . 'controller.php');
        require_once(ROOTPATH.'Source Files/src/controller/Controller.php');
        require_once(ROOTPATH.'Source Files/src/controller/' . $controller . 'Controller.php');

        switch($controller) {
            case 'SignUp':  $controller = new SignUpController();
                            break;
            case 'Login':   $controller = new LoginController();
                            echo 'login';
                            break;
        }
        $controller->$action();
    }

    // we're adding an entry for the new controller and its actions
    $controllers = array('Login'    => ['checkLoginAction']
                       , 'SignUp'   => ['signUpAction']);

    if (array_key_exists($controller, $controllers) && in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        require_once(__DIR__.'/../../app/config/constants.php');
        $html = str_replace("{{pageTitle}}", "Error Page", $html);
        $html = str_replace("{{pageContent}}", "wrong action", $html);
    }
?>
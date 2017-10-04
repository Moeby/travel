<?php
/**
 * Created by PhpStorm.
 * User: Nadja
 * Date: 27.09.2017
 * Time: 09:27
 */

    function call($controller, $action) {

        //require_once(__DIR__.'\\..\\..\\src\\controller\\' . $controller . 'controller.php');
        require_once('../../src/controller/' . $controller . 'controller.php');

        switch($controller) {
            case 'Login':   $controller = new LoginController();
                            echo 'login';
                            break;
        }
        $controller->$action();
    }

    // we're adding an entry for the new controller and its actions
    $controllers = array('Login' => ['checkLoginAction']);

    if (array_key_exists($controller, $controllers) && in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        $html = str_replace("{{pageTitle}}", "Error Page", $html);
        $html = str_replace("{{pageContent}}", "wrong action", $html);
    }
?>
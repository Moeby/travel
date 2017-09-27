<?php
/**
 * Created by PhpStorm.
 * User: Nadja
 * Date: 27.09.2017
 * Time: 09:27
 */

    require_once('controller/ErrorController.php');
    ErrorController::noDirectExecution();

    function call($controller, $action) {
        require_once('controller/' . $controller . 'Controller.php');

        switch($controller) {
            case 'StartPage':   require_once('model/Account.php');
                $controller = new StartPageController();
                break;
            case 'Journal':     require_once('model/JournalEntry.php');
                $controller = new JournalController();
                break;
            default:            $controller = new ErrorController();
                $action = 'notSupported';
        }

        $controller->$action();
    }

    // we're adding an entry for the new controller and its actions
    $controllers = array('StartPage' => ['home', 'add', 'delete', 'update'],
        'Journal' => ['journal', 'add', 'delete', 'update']);

    if (array_key_exists($controller, $controllers) && in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        $html = str_replace("{{pageTitle}}", "Error Page", $html);
        $html = str_replace("{{pageContent}}", ErrorController::notSupported(), $html);
    }
?>
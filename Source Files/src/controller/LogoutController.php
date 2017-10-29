<?php
namespace Travel\Controller;

use Travel\Controller\LoginController;

class LogoutController extends Controller
{
    public function logoutAction($html){
        session_register_shutdown();
        //TODO: check if necessary
        unset($_SESSION['user']);
        $html = file_get_contents("../app/resources/view/templateLogin.html");
        $html = str_replace("{{goToResource}}", '../app/resources/', $html);
        $login = new LoginController();
        echo $login->loginAction($html);
    }
}
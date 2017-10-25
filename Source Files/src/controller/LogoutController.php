<?php
namespace Travel\Controller;

use Travel\Controller\LoginController;

class LogoutController extends Controller
{
    public function logoutAction($html){
        session_register_shutdown();
        $html = file_get_contents("../app/resources/view/templateLogin.html");
        $login = new LoginController();
        $login->loginAction($html);
    }
}
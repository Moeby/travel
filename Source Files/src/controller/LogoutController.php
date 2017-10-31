<?php

namespace Travel\Controller;

class LogoutController extends Controller
{
    /**
     * Close session to log out User, load login view
     *
     * @param $html
     */
    public function logoutAction($html)
    {
        session_register_shutdown();
        unset($_SESSION['user']);
        $html = file_get_contents("../app/resources/view/templateLogin.html");
        $html = str_replace("{{goToResource}}", '../app/resources/', $html);
        $login = new LoginController();
        echo $login->loginAction($html);
    }
}
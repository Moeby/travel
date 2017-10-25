<?php
namespace Travel\Controller;

namespace Travel\LoginController;

class LogoutController extends Controller
{
    public function logoutAction($html){
        session_write_close();
        $login = new LogoutController();
        $login->loginAction($html);
    }
}
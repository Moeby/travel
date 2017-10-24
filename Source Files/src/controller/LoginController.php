<?php

class LoginController extends Controller {

    public function logoutAction() {
    }


    public function configureOptions(OptionsResolver $resolver) {

    }

    public function loginAction(){
        $htmlLogin = file_get_contents(RESOURCE_ROOT."view/login.html");
        $htmlLogin = str_replace("{{rootpath}}", ROOTPATH, $htmlLogin);
        $htmlLogin = str_replace("{{pageContent}}", $htmlLogin, this->$html);
    }

    function checkPassword(){
        $username = $_POST["username"];
        $password = $_POST["password"];
        //get user from db with username
        $compPassword = $user.get_password();
        $pepper       = "NatAnA";
        $salt         = $user.get_salt();
        $saltpepper   = $salt + $pepper;
        $options      = [
            'salt' => $saltpepper
            //    $salt = uniqid(mt_rand(), true);
        ];
        if($compPassword === password_hash($password, PASSWORD_BCRYPT, $options)){
            return true;
        } else {
            return false;
        }
    }

}
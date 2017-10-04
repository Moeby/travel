<?php

class LoginController extends Controller {

    public function logoutAction() {
    }


    public function configureOptions(OptionsResolver $resolver) {

    }

    public function loginAction(){
        $content = file_get_contents(ROOTPATH."Source Files/app/resources/view/login.html");
        $htmlLogin = str_replace("{{pageContent}}", $content, $htmlLogin);
    }

    function checkPassword($password, $user){
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
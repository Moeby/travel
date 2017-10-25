<?php

class SignUpController extends Controller {

    public function signUpAction($html) {
        $content = file_get_contents(ROOTPATH."Source Files/app/resources/view/signUp.html");
        //$content = str_replace("{{rootpath}}", ROOTPATH, $content);
        //$htmlLogin = str_replace("{{pageContent}}", $content, $htmlLogin);
        $html = str_replace("{{pageTitle}}", 'Signup', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    public function registerAction($html){
        if (!empty($_POST)){
            var_dump($_POST);
        }else{
            echo "empry post request or get request";           
        }
        exit;//redirect here
    }

    private function newUser($username,$password){
        
    }

    function setSaltedHash($password) {
        $pepper     = "NatAnA";
        $salt       = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        //salt noch in DB speichern!
        $saltpepper = $salt + $pepper;
        $options    = [
            'salt' => $saltpepper
            //    $salt = uniqid(mt_rand(), true);
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}

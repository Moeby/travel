<?php
namespace  Travel\Controller;

class LoginController extends Controller {

    public function logoutAction() {
    }


    public function configureOptions(OptionsResolver $resolver) {

    }

    /*http://localhost/travel/travel/Source%20Files/src/index.php?controller=Login&action=loginAction*/
    public function loginAction($html){   
        $content = file_get_contents(ROOTPATH."Source Files/app/resources/view/login.html");
        $content = str_replace("{{rootpath}}", ROOTPATH, $content);
        $htmlLogin = str_replace("{{pageContent}}", $content, $html);

        return $htmlLogin;
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
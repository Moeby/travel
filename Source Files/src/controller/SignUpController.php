<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";
class SignUpController extends Controller {

    public function signUpAction($html) {
        $content = file_get_contents(ROOTPATH."Source Files/app/resources/view/signUp.html");
        $html = str_replace("{{pageTitle}}", 'Signup', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    public function registerAction($html){
        echo $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";
        if (!empty($_POST)){
            $em = $this->getEntityManager();
            $xxx = $em->getRepository('Travel\Entity\User')->findAll();
            var_dump($xxx);
        }else{
            echo "Empty post request";
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

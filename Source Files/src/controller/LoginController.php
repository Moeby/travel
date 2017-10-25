<?php
namespace  Travel\Controller;

use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;

class LoginController extends Controller {

    public $salt;
    public $pepper = "NatAnA";
    public $error  = "";
    public $signup = 'You don\'t have a Travelling I Account yet? <a href=\"{{rootpath}}Source Files/src/index.php\">Sign up here...</a>';

    //TODO: logout + session close
    public function logoutAction() {
        
    }


    public function configureOptions(OptionsResolver $resolver) {

    }

    /*http://localhost/travel/travel/Source%20Files/src/index.php?controller=Login&action=loginAction*/
    public function loginAction($html){
        $content = file_get_contents(RESOURCE_ROOT."view/signUp.html");
        $html = str_replace("{{pageTitle}}", 'Login', $html);
        $html = str_replace("{{pageContent}}", $content, $html);
        $html = str_replace("{{error}}", $this->error, $html);
        $html = str_replace("{{signup}}", $this->signup, $html);

        return $html;
    }

    public function checkUserAction($html){
        if (!empty($_POST)){
            $username      = $_POST["username"];
            $givenPassword = $_POST["password"];

            $criteria     = array('username'=>$username);
            $em           = $this->getEntityManager();
            $user         = $em->getRepository('Travel\Entity\User')->findBy($criteria);

            if(empty($user)){
                $password     = $user->getPassword();
                $this->salt   = $user->getSalt();

                $compPassword = $this->getSaltedHash($givenPassword);

                if($compPassword === $password){
                    //TODO: login
                } else {
                    //TODO: error message and another time login html
                    $this->error  = "Invalid password.";
                    $this->signup = "";
                    echo $this->loginAction($html);
                }
            } else {
                $this->error  = "Username not correct.";
                $this->signup = 'You don\'t have a Travelling I Account yet? <a href=\"{{rootpath}}Source Files/src/index.php\">Sign up here...</a>';
                echo $this->loginAction($html);
            }
        }else{
            echo "Empty post request";
        }
        exit;//redirect here
    }

    function getSaltedHash($password)
    {
        $options = [
            'salt' => $this->salt
        ];
        return password_hash($password . $this->pepper, PASSWORD_BCRYPT, $options);
    }

}
<?php
namespace  Travel\Controller;

use Travel\Entity\User;
use Travel\Controller\MapController;

use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;

class LoginController extends Controller {

    public $salt;
    public $pepper = "NatAnA";
    public $error  = "";

    public function configureOptions(OptionsResolver $resolver) {

    }

    /*http://localhost/travel/travel/Source%20Files/src/index.php?controller=Login&action=loginAction*/
    public function loginAction($html){
        $content = file_get_contents(RESOURCE_ROOT."view/login.html");
        $html = str_replace("{{pageTitle}}", 'Login', $html);
        $html = str_replace("{{pageContent}}", $content, $html);
        $html = str_replace("{{error}}", $this->error, $html);

        return $html;
    }

    public function checkUserAction($html){
        //TODO: check if better way exists
        unset($_SESSION['user']);
        if (!empty($_POST)){
            $username      = $_POST["username"];
            $givenPassword = $_POST["password"];

            $criteria     = array('username'=>$username);
            $em           = $this->getEntityManager();
            $user         = $em->getRepository('Travel\Entity\User')->findOneBy($criteria);

            if(!empty($user)){
                $password     = $user->getPassword();
                $this->salt   = $user->getSalt();

                $compPassword = $this->getSaltedHash($givenPassword);

                //TODO: check login errors (if wrong password, no login!)
                if(strcmp($compPassword, $password) == 0){
                    $_SESSION['user'] = $username;
                    $map = new MapController;
                    echo $map->mapAction($html);
                } else {
                    $this->error  = "Invalid credentials.";
                    echo $this->loginAction($html);
                    /*echo "Passworderror";
                    if(isset($_SESSION['user'])) {
                        echo " session set ";
                        echo $_SESSION['user'];
                    }*/
                }
            } else {
                $this->error  = "Invalid credentials.";
                echo $this->loginAction($html);
                /*echo "username error";
                if(isset($_SESSION['user'])) {
                    echo " session set ";
                    echo $_SESSION['user'];
                }*/
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
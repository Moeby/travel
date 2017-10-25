<?php
namespace  Travel\Controller;

use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;

class LoginController extends Controller {

    public $salt;

    public function logoutAction() {

    }


    public function configureOptions(OptionsResolver $resolver) {

    }

    /*http://localhost/travel/travel/Source%20Files/src/index.php?controller=Login&action=loginAction*/
    public function loginAction($html){   
        $content = file_get_contents(RESOURCE_ROOT."view/login.html");
        $content = str_replace("{{rootpath}}", ROOTPATH, $content);
        $html    = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    public function checkUserAction(){
        if (!empty($_POST)){
            $username      = $_POST["username"];
            $givenPassword = $_POST["password"];

            $criteria     = array('username'=>$username);
            $em           = $this->getEntityManager();
            $user         = $em->getRepository('Travel\Entity\User')->findBy($criteria);
            $password     = $user->getPassword();
            salt          = $user->getSalt();

            $compPassword = $this->getSaltedHash($givenPassword);
        }else{
            echo "Empty post request";
        }
        exit;//redirect here
    }

    function checkPassword(){


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

    function getSaltedHash($password)
    {
        $this->salt = $this->genSalt();
        $options = [
            'salt' => $this->salt
        ];
        return password_hash($password . $this->pepper, PASSWORD_BCRYPT, $options);
    }

}
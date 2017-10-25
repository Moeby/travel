<?php
namespace Travel\Controller;

use Travel\Entity\User;
use Travel\Controller\MapController;

class SignUpController extends Controller
{
    public $error = "";
    public $salt;
    public $pepper = "NatAnA";

    public function signUpAction($html)
    {
        $content = file_get_contents(ROOTPATH . "Source Files/app/resources/view/signUp.html");
        $html = str_replace("{{pageTitle}}", 'Signup', $html);
        $html = str_replace("{{pageContent}}", $content, $html);
        $html = str_replace("{{error}}", $this->error, $html);

        return $html;
    }

    public function registerAction($html)
    {
        echo $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";
        if (!empty($_POST)) {
            $em = $this->getEntityManager();
            //check if username already taken
            $username_exists = $em->getRepository('Travel\Entity\User')->findOneBy(array('username' => $_POST['username']));

            if (!empty($username_exists)) {
                $this->error = "Username already taken. Please choose a different one.";
                echo $this->signUpAction($html);
            } else {
                $newUser = new User();
                $newUser->setUsername($_POST['username']);
                $newUser->setPassword($this->getSaltedHash($_POST['password']));
                $newUser->setSalt($this->salt);

                $em->persist($newUser);
                $em->flush();

                //set logged in user in Session
                $_SESSION['user'] = $_POST['username'];
                $map = new MapController;
                echo $map->mapAction($html);
            }
        } else {
            echo "Empty post request";
        }
        $this->signUpAction($html);
    }

    private function newUser($username, $password)
    {

    }

    function getSaltedHash($password)
    {
        $this->salt = $this->genSalt();
        $options = [
            'salt' => $this->salt
        ];
        return password_hash($password . $this->pepper, PASSWORD_BCRYPT, $options);
    }

    public function genSalt() {
        $seed = '';
        for($i = 0; $i < 16; $i++) {
            $seed .= chr(mt_rand(0, 255));
        }
        /* GenSalt */
        $salt = substr(strtr(base64_encode($seed), '+', '.'), 0, 22);
        /* Return */
        return $salt;
    }
}

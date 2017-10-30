<?php

namespace Travel\Controller;

class LoginController extends Controller
{

    public $salt;
    public $pepper = "NatAnA";
    public $error = "";
    public $givenUsername = "";

    public function loginAction($html)
    {
        $content = file_get_contents(RESOURCE_ROOT . "view/login.html");
        $html = str_replace("{{pageTitle}}", 'Login', $html);
        $html = str_replace("{{pageContent}}", $content, $html);
        $html = str_replace("{{error}}", $this->error, $html);
        $html = str_replace("{{username}}", $this->givenUsername, $html);

        return $html;
    }

    public function checkUserAction($html)
    {
        unset($_SESSION['user']);
        if (!empty($_POST)) {
            $username = $_POST["username"];
            $givenPassword = $_POST["password"];

            $criteria = array('username' => $username);
            $em = $this->getEntityManager();
            $user = $em->getRepository('Travel\Entity\User')->findOneBy($criteria);

            if (!empty($user)) {
                $password = $user->getPassword();
                $this->salt = $user->getSalt();
                $compPassword = $this->getSaltedHash($givenPassword);

                if (strcmp($compPassword, $password) == 0) {
                    $_SESSION['user'] = $username;
                    $map = new MapController;
                    echo $map->mapAction($html);
                } else {
                    $this->error = "Password invalid.";
                    $this->givenUsername = $username;
                    echo $this->loginAction($html);
                }
            } else {
                $this->error = "Invalid credentials.";
                echo $this->loginAction($html);
            }
        } else {
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
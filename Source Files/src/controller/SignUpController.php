<?php

namespace Travel\Controller;

use DateTime;
use Travel\Entity\User;

class SignUpController extends Controller
{
    public $error = "";
    public $salt;
    public $pepper = "NatAnA";

    /**
     * Show signup view
     *
     * @param $html
     * @return assembled html
     */
    public function signUpAction($html)
    {
        $content = file_get_contents(ROOTPATH . "Source Files/app/resources/view/signUp.html");
        $html = str_replace("{{pageTitle}}", 'Signup', $html);
        $html = str_replace("{{pageContent}}", $content, $html);
        $html = str_replace("{{error}}", $this->error, $html);

        return $html;
    }

    /**
     * Add the new user if username is not already taken
     *
     * @param $html
     */
    public function registerAction($html)
    {
        unset($_SESSION['user']);
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
                $this->addHomeLocation($em, $newUser);

                //set logged in user in Session
                $_SESSION['user'] = $_POST['username'];
                $map = new MapController;
                echo $map->mapAction($html);
            }
        } else {
            echo "Empty post request";
            exit;
        }
        $this->signUpAction($html);
    }

    /**
     * Add location with home flag
     *
     * @param $em Entity Manager
     * @param $newUser the newly created User obj
     */
    public function addHomeLocation($em, $newUser): void
    {
        $location_exists = $em->getRepository('Travel\Entity\Location')->findOneBy(array('name' => $_POST['locationName'], 'latitude' => $_POST['lat'], 'longitude' => $_POST['lng']));

        if (!empty($location_exists)) {
            $newLocation = $location_exists;
        } else {
            $newLocation = new \Travel\Entity\Location();
            $newLocation->setLatitude($_POST['lat']);
            $newLocation->setLongitude($_POST['lng']);
            $newLocation->setName($_POST['locationName']);
            $em->persist($newLocation);
            $em->flush();
        }
        $date = new DateTime();
        $newPost = new \Travel\Entity\Post();
        $newPost->setDate($date);
        $newPost->setText("");
        $newPost->setTitle($_POST['locationName']);

        $em->persist($newPost);
        $em->flush();

        $userHasLocation = new \Travel\Entity\UserHasLocation();
        $userHasLocation->setLocation($newLocation);
        $userHasLocation->setUser($newUser);
        $userHasLocation->setPost($newPost);
        $userHasLocation->setHome(true);

        $em->persist($userHasLocation);
        $em->flush();
    }

    private function getSaltedHash($password)
    {
        $this->salt = $this->genSalt();
        $options = [
            'salt' => $this->salt
        ];
        return password_hash($password . $this->pepper, PASSWORD_BCRYPT, $options);
    }

    private function genSalt()
    {
        $seed = '';
        for ($i = 0; $i < 16; $i++) {
            $seed .= chr(mt_rand(0, 255));
        }
        $salt = substr(strtr(base64_encode($seed), '+', '.'), 0, 22);

        return $salt;
    }
}

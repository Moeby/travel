<?php

namespace Travel\Controller;

use Travel\Entity\Picture;

class PostController extends Controller
{

    /**
     * Show the edit post page for the selected Post
     *
     * @param $html
     * @return assembled edit post view
     */
    public function editPostAction($html)
    {
        $em = $this->getEntityManager();
        $postId = $_GET['id'];
        $post = $em->getRepository('Travel\Entity\Post')->findOneById($postId);
        $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $this->getCurrentUser(), "post" => $post));

        if (isset($_SESSION['user']) && !empty($userHasLocation)) {
            $postText = $post->getText();
            $postTitle = $post->getTitle();

            $content = file_get_contents(RESOURCE_ROOT . "view/editPost.html");
            $content = str_replace('{{postTitle}}', $postTitle, $content);
            $content = str_replace('{{postText}}', $postText, $content);
            $content = str_replace('{{postId}}', $postId, $content);

            $html = str_replace("{{username}}", $this->getCurrentUser()->getUsername(), $html);
            $html = str_replace("{{pageTitle}}", 'Add a Post', $html);
            $html = str_replace("{{pageContent}}", $content, $html);
        } else {
            $html = $this->showPostsAction($html);
        }

        return $html;
    }

    /**
     * Show all posts for logged in user
     *
     * @param $html
     * @return assembled view posts
     */
    public function showPostsAction($html)
    {
        if (isset($_SESSION['user'])) {
            $em = $this->getEntityManager();

            $user = $this->getCurrentUser();
            $locations = $user->getLocation();
            $posts = array();
            $content = "";

            foreach ($locations as $location) {
                $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $user, "location" => $location));
                if (!$userHasLocation->isHome()) {
                    $posts[] = $userHasLocation->getPost();
                }
            }

            foreach ($posts as $post) {
                $content .= "<div class='blogpost'>";
                $content .= "<h2>" . $post->getTitle() . "</h2>";
                $pictures = $post->getPictures();

                foreach ($pictures as $pic) {
                    $img = 'http://localhost/travel/travel' . $pic->getFilename();
                    $content .= "<img height='200px' src='" . $img . "'/>";
                }
                $content .= $post->getText();
                $content .= "<a class='button' href='http://localhost/travel/travel/Source%20Files/src/index.php?controller=Post&action=editPostAction&id=" . $post->getId() . "'>Edit</a>";
                $content .= "<a class='button' id='link2' href='http://localhost/travel/travel/Source%20Files/src/index.php?controller=Post&action=deletePostAction&id=" . $post->getId() . "'>Delete</a>";
                $content .= "</div>";
            }
            $html = str_replace("{{pageTitle}}", 'All Posts', $html);
            $html = str_replace("{{pageContent}}", $content, $html);
            $html = str_replace("{{username}}", $_SESSION['user'], $html);
        } else {
            $content = file_get_contents(RESOURCE_ROOT . 'view/login.html');
            $html = str_replace("{{pageTitle}}", 'Login', $html);
            $html = str_replace("{{pageContent}}", $content, $html);
            $html = str_replace("{{error}}", "", $html);
            $html = str_replace("{{username}}", "", $html);
        }

        return $html;
    }

    /**
     *  Add post
     */
    public function addPostAction()
    {
        $em = $this->getEntityManager();
        $post = $em->getRepository('Travel\Entity\Post')->findOneById($_POST['postId']);
        $user = $this->getCurrentUser();
        $userHasLocation = $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $user, "post" => $post));

        //check that the post belongs to the user that is logged in
        if ($user->getUsername() === $userHasLocation->getUser()->getUsername()) {
            $post->setText($_POST['postText']);
            $post->setTitle($_POST['postTitle']);
            $em->persist($post);
            $em->flush();
            $pictures = [];

            $username = $_SESSION['user'];
            $relativeDir = "images/" . $username . "/";
            $target_dir = RESOURCE_ROOT . $relativeDir;
            $this->createFolder($target_dir);

            if (is_dir($target_dir)) {
                if (isset($_FILES['pictures']) && 0 != $_FILES['pictures']['size']['0']) {
                    $myFile = $_FILES['pictures'];
                    $fileCount = count($myFile["name"]);
                    //check each image
                    $pictures = $this->checkPicture($fileCount, $target_dir, $myFile, $pictures);
                }
                $this->makeNewImages($pictures, $post);
                $this->redirectShowPosts();
            } else {
                echo "dir not existing " . $target_dir;
                exit;
            }
        } else {
            echo "You do not have the required permissions to edit this post";
            exit;
        }
    }

    /**
     * @param $fileCount
     * @param $target_dir
     * @param $myFile
     * @param $pictures
     * @return array
     */
    public function checkPicture($fileCount, $target_dir, $myFile, $pictures): array
    {
        for ($i = 0; $i < $fileCount; $i++) {
            $uploadOk = 0;
            $target_file = $target_dir . basename($myFile["name"][$i]);
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            // check if image file is a actual image or fake image
            if ((getimagesize($myFile["tmp_name"][$i])) === false) {
                echo $myFile["name"][$i] . " is not an image.";
                $uploadOk = 1;
            }
            // check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, \"" . $myFile["name"][$i] . "\" already exists.";
                $uploadOk = 1;
            }
            // check file size
            if ($myFile["size"][$i] > 5000000) {
                echo "Sorry, \"" . $myFile["name"][$i] . "\" is too large.";
                $uploadOk = 1;
            }
            // allow certain file formats
            if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 1;
            }
            // as everything is fine you can add the picture to the directory
            if ($uploadOk < 1) {
                if (move_uploaded_file($myFile["tmp_name"][$i], $target_file)) {
                    $pictures[] = str_replace(ROOTPATH, '', $target_file);//$relativeDir.basename($myFile["name"][$i]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    exit;
                }
            } else {
                echo "error";
                exit;
            }
        }
        return $pictures;
    }


    function getPost($html)
    {
        $content = file_get_contents(RESOURCE_ROOT . "view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    function deletePostAction($html)
    {
        $em = $this->getEntityManager();
        $postId = $_GET['id'];
        $post = $em->getRepository('Travel\Entity\Post')->findOneById($postId);
        $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $this->getCurrentUser(), "post" => $post));

        if (isset($_SESSION['user']) && !empty($userHasLocation)) {
            $em = $this->getEntityManager();
            $user = $this->getCurrentUser();

            $postId = $_GET['id'];
            $post = $em->getRepository('Travel\Entity\Post')->findOneById($postId);

            $userHasLocation = $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $user, "post" => $post));

            //check that the post belongs to the user that is logged in
            if ($user->getUsername() === $userHasLocation->getUser()->getUsername()) {
                $pictures = $post->getPictures();

                foreach ($pictures as $picture) {
                    unlink(ROOTPATH . $picture->getFilename());
                    $em->remove($picture);
                    $em->flush();
                }
                $em->remove($userHasLocation);
                $em->remove($post);
                $em->flush();
                echo $this->showPostsAction($html);
            } else {
                echo "You do not have the required permissions to delete this post";
                exit;
            }
        } else {
            echo "You do not have the necessary permissions to delete this post";
            exit;
        }
    }

    private function createFolder($dir_name)
    {
        if (!is_dir($dir_name)) {
            mkdir($dir_name, 0777, true);
        }
    }

    private function redirectShowPosts()
    {
        header("Location: http://localhost/travel/travel/Source%20Files/src/index.php?controller=Post&action=showPostsAction");
        die();
    }

    private function makeNewImages($images, $post)
    {
        $em = $this->getEntityManager();
        $post = $post = $em->getRepository('Travel\Entity\Post')->findOneById($post->getId());
        foreach ($images as $image) {
            $newImage = new Picture();
            $newImage->setFilename($image);
            $newImage->setName("myFilename");
            $newImage->setPost($post);
            $em->persist($newImage);
        }
        $em->flush();
    }
}
<?php
namespace Travel\Controller;

class PostController extends Controller {

    public function showAddPostAction($html){
        $content = file_get_contents(RESOURCE_ROOT."view/addPost.html");

        $html = str_replace("{{pageTitle}}", 'Add a Post', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    public function showPostsAction($html){
        $em = $this->getEntityManager();

        $em->getRepository('Travel\Entity\Post')->findAll();
        var_dump($em);
        //$criteria = array('' => $user->getId());
        //$em->getRepository('Travel\Entity\Post')->findBy($criteria);
        //$this->getPost($html);

        return $html;
    }

    public function addPostAction(){
        $em = $this->getEntityManager();
        //$em->getRepository('Travel\Entity\User')->findOneBy();

        $username   = $_SESSION['user'];
        $dir_name   = RESOURCE_ROOT."images/".$username."/";
        $target_dir =mkdir($dir_name);
        if(is_dir($target_dir)){
            if (isset($_FILES['pictures'])) {
                $myFile = $_FILES['pictures'];
                $fileCount = count($myFile["name"]);

                for ($i = 0; $i < $fileCount; $i++) {
                    echo $myFile["name"][$i];
                }
            }
        } else {
            //TODO: Error, we can't make you a new dir
        }
        /*
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if (isset($_FILES['pictures'])) {
            $myFile = $_FILES['pictures'];
            $fileCount = count($myFile["name"]);

            for ($i = 0; $i < $fileCount; $i++) {
                    echo $myFile["name"][$i];
            }
        }
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        */
    }

    function getPost($html){
        $content = file_get_contents(RESOURCE_ROOT."view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }
}
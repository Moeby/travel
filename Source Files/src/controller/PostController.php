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
        if(!is_dir($dir_name)){
            $target_dir = mkdir($dir_name);
        } else {
            $target_dir = $dir_name;
        }

        if(is_dir($target_dir)){
            if (isset($_FILES['pictures'])) {
                $myFile = $_FILES['pictures'];
                $fileCount = count($myFile["name"]);

                //check each image
                for ($i = 0; $i < $fileCount; $i++) {
                    $uploadOk    =  0;
                    $target_file = $target_dir.basename($myFile["name"][$i]);
                    $file_type    = pathinfo($target_file,PATHINFO_EXTENSION);

                    echo $myFile["tmp_name"][$i];

                    // check if image file is a actual image or fake image
                    if((getimagesize($myFile["tmp_name"][$i])) === false) {
                        echo $myFile["name"][$i]." is not an image.";
                        $uploadOk = 1;
                    }
                    // check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, \"".$myFile["name"][$i]."\" already exists.";
                        $uploadOk = 1;
                    }
                    // check file size
                    if ($myFile["size"][$i] > 5000000) {
                        echo "Sorry, \"".$myFile["name"][$i]."\" is too large.";
                        $uploadOk = 1;
                    }
                    // allow certain file formats
                    if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 1;
                    }
                    // as everything is fine you can add the picture to the directory
                    if($uploadOk < 1) {
                        if (move_uploaded_file($myFile["tmp_name"][$i], $target_file)) {
                            // TODO: add name of picture and post id to new picture element
                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }
        } else {
            //TODO: Error, we can't make you a new dir
        }
    }

    function getPost($html){
        $content = file_get_contents(RESOURCE_ROOT."view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }
}
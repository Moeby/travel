<?php
namespace Travel\Controller;
use Travel\Entity\Post;
use Travel\Entity\Picture;
use DateTime;

class PostController extends Controller {

    public function showAddPostAction($html){
        $content = file_get_contents(RESOURCE_ROOT."view/addPost.html");

        $html = str_replace("{{pageTitle}}", 'Add a Post', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }

    public function showPostsAction($html){
        $em = $this->getEntityManager();
        $dir_name   = RESOURCE_ROOT."images/".$_SESSION['user']."/";

        $user = $em->getRepository('Travel\Entity\User')->findOneBy(array("username" => $_SESSION['user']));
        $locations = $user->getLocation();
        $posts = array();

        foreach ($locations as $location) {
            $userHasLocation = $em->getRepository('Travel\Entity\UserHasLocation')->findOneBy(array("user" => $user, "location" => $location));
            if (!$userHasLocation->isHome()){
                $posts[] = $userHasLocation->getPost();
            }
        }

        $content="";
        foreach ($posts as $post) {
            $content .= "<div>";
            $content .=  $dir_name;
            $content .="<h1>". $post->getTitle()."</h1>";            
            $content .= $post->getText();
            $content .= "</div>";
        }

        $html = str_replace("{{pageTitle}}", 'All Posts', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }


    private function createFolder($dir_name){
        if(!is_dir($dir_name)){
            $target_dir = mkdir($dir_name,0777,true);
        }        
    }

    public function addPostAction(){
        $em = $this->getEntityManager();
        $pictures = [];
        //$em->getRepository('Travel\Entity\User')->findOneBy();

        $username   = $_SESSION['user'];
        $target_dir   = RESOURCE_ROOT."images/".$username."/";
        $this->createFolder($target_dir);

        if(is_dir($target_dir)){
            if (isset($_FILES['pictures']) && 0 != $_FILES['pictures']['size']['0']) {
                $myFile = $_FILES['pictures'];
                $fileCount = count($myFile["name"]);
                //check each image
                for ($i = 0; $i < $fileCount; $i++) {
                    $uploadOk    =  0;
                    $target_file = $target_dir.basename($myFile["name"][$i]);
                    $file_type    = pathinfo($target_file,PATHINFO_EXTENSION);                    

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
                            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                            $pictures[] = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";exit;
                        }
                    }
                }
            }
            $postId = $this->makeNewPost($_POST['postTitle'],$_POST['postText'],new DateTime()); 
            $pictures = $this->makeNewImages($pictures);
           
            $this->redirectShowPosts();
        } else {
            //TODO: Error, we can't make you a new dir
        }
    }

    private function redirectShowPosts(){
        header("Location: http://localhost/travel/travel/Source%20Files/src/index.php?controller=Post&action=showPostsAction");
        die();
    }

    private function makeNewImages($images){
        $em = $this->getEntityManager();
        foreach ($images as $image) {
            $newImage = new Picture();
            $newImage->setFilename($image);
            $newImage->setName("myFilename");//@todo add real filename
        }
        $em->flush();
    }

    private function makeNewPost($title,$text,$date){
        $em = $this->getEntityManager();
        //set user
        $newPost = new Post();
        $newPost->setTitle($title);
        $newPost->setText($text);
        $newPost->setDate($date);        
        $em->persist($newPost);
        $em->flush();

        return $newPost->getId();
    }

    function getPost($html){
        $content = file_get_contents(RESOURCE_ROOT."view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }
}
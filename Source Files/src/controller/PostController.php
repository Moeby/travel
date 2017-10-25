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
        if (isset($_FILES['pictures'])) {
            $myFile = $_FILES['pictures'];
            $fileCount = count($myFile["name"]);

            for ($i = 0; $i < $fileCount; $i++) {
                    echo $myFile["name"][$i];
            }
        }
    }

    function getPost($html){
        $content = file_get_contents(RESOURCE_ROOT."view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }
}
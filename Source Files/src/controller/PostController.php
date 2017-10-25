<?php
namespace Travel\Controller;

class PostController extends Controller {

    public function addPostAction($html){
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

    function getPost($html){
        $content = file_get_contents(RESOURCE_ROOT."view/post.html");

        $html = str_replace("{{pageTitle}}", 'PostTitle', $html);
        $html = str_replace("{{pageContent}}", $content, $html);

        return $html;
    }
}
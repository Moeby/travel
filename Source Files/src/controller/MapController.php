<?php

namespace Travel\Controller;

class MapController extends Controller
{
    public function mapAction($html)
    {
        if (isset($_SESSION['user'])) {
            $html = file_get_contents("../app/resources/view/template.html");
            $html = str_replace("{{goToResource}}", '../app/resources/', $html);
            $content = file_get_contents(RESOURCE_ROOT . 'view/map.html');
            $html = str_replace("{{pageTitle}}", 'Traveling ' . $_SESSION['user'], $html);
            $html = str_replace("{{username}}", $_SESSION['user'], $html);
            $html = str_replace("{{pageContent}}", $content, $html);

            return $html;
        } else {
            $content = file_get_contents(RESOURCE_ROOT . 'view/login.html');
            $html = str_replace("{{pageTitle}}", 'Login', $html);
            $html = str_replace("{{pageContent}}", $content, $html);
            $html = str_replace("{{error}}", "", $html);
            $html = str_replace("{{username}}", "", $html);

            return $html;
        }
    }
}
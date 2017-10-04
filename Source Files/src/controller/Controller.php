<?php

abstract class Controller
{
    public function __construct()
    {
        //DB Class hinzufügen

        require_once(__DIR__.'/../../app/config/constants.php');
        // für DB-Connect
        require_once(__DIR__.'/../../app/config/dbConfig.php');

        $html      = file_get_contents(ROOTPATH."Source Files/app/resources/view/template.html");
        $htmlLogin = file_get_contents(ROOTPATH."Source Files/app/resources/view/templateLogin.html");
    }

}
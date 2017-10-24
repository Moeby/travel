<?php

abstract class Controller
{
    public $html;

    public function __construct()
    {
        //DB Class hinzufügen

        require_once(__DIR__ . '/../../app/config/constants.php');
        // für DB-Connect
        require_once(__DIR__ . '/../../app/config/dbConfig.php');
        $this->html = file_get_contents(RESOURCE_ROOT ."view/template.html");

        //TODO: check if user logged in, otherwise show this page
        //$htmlLogin = file_get_contents(RESOURCE_ROOT ."view/templateLogin.html");
    }

}
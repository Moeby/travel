<?php
/**
 * Created by PhpStorm.
 * User: natal
 * Date: 04.10.2017
 * Time: 08:52
 */

namespace Controller;


abstract class Controller
{
    public function __construct()
    {
        //DB Class hinzufügen

        require_once(__DIR__.'/../../app/config/constants.php');
        // für DB-Connect
        require_once(__DIR__.'/../../app/config/dbConfig.php');
    }





}
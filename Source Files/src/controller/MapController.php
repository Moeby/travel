<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/travel/travel/Source Files/app/config/dbConfig.php";
class MapController extends Controller
{

    public function mapAction($html){
        $content = file_get_contents(RESOURCE_ROOT.'view/map.html');
    }

    public function getAllPostItems(){
        $em = $this->getEntityManager();
        //TODO: get all location_user with certain user, get posts to this location_user and fill in array [latitude, longitude, postname]
    }
}
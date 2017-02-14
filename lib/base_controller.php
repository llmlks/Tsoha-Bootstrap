<?php

class BaseController {

    public static function get_user_logged_in() {

        if (isset($_SESSION['user'])) {
            $id = $_SESSION['user'];
            
            $band = Band::findwithid($id);
            
            return $band;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Please log in first'));
        }
    }

}

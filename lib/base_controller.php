<?php

class BaseController {

    public static function get_user_logged_in() {

        if (isset($_SESSION['user'])) {
            $id = $_SESSION['user'];
            
            $band = Band::find_with_id($id);
            
            return $band;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Please log in first'));
        }
    }
    
    public static function check_admin() {
        if (!isset($_SESSION['admin'])) {
            Redirect::to('/');
        }
    }
    
    public static function check_logged_in_or_admin() {
        if (!(isset($_SESSION['user']) || isset($_SESSION['admin']))) {
            Redirect::to('/');
        }
    }
    
    public static function get_admin_logged_in() {
        
        if (isset($_SESSION['admin'])) {
            return $_SESSION['admin'];
        }
        return null;
    }
}

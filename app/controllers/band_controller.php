<?php

class BandController extends BaseController {
    
    public static function band_show($id) {
        
        $band = Band::findwithid($id);
        
        View::make('suunnitelmat/band_show.html', array('band' => $band));
    }
    
    public static function favourites($id) {
        
        $favourites = Band::favourites($id);
        
        View::make('suunnitelmat/favourite_list.html', array('favourites' => $favourites));
    }
    
    public static function searchWithName() {
        
        $bands = Band::findwithname($_POST["search"]);
        
        if ($bands == null) {
            Redirect::to("/");
        }
        
        View::make('suunnitelmat/search_list.html', array('bands' => $bands));
    }
    
    public static function signup() {
        
        View::make('suunnitelmat/signup.html');
    }
    
    public static function newband() {
        $params = $_POST;
        
        $band = new Band(array(
            'bandname' => $params['bandname'],
            'description' => $params['description'],
            'origin' => $params['origin'],
            'username' => $params['username'],
            'password' => $params['password']
        ));
        
        $band->save();
        $id = $band->id;
        
        Redirect::to('/band/' . $id);
    }
    
    public static function home(){
        
        $bands = Band::findall();
        
        View::make('suunnitelmat/home.html', array('bands' => $bands));
    }    
}

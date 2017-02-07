<?php

class FavouriteController extends BaseController {
    
    public static function favourites($id) {

        $favourites = Favourite::findAll($id);
        
        foreach ($favourites as $band) {
            $band->nextgig = Gig::findBandsNextGig($id);
        }

        View::make('favourite_list.html', array('favourites' => $favourites));
    }    
    
    public static function newfavourite() {
        
        $params = $_POST;
        
        $favourite = new Favourite(array(
            'favourite' => $params['id'],
            'band_id' => $_SESSION['user']
        ));
        
        $favourite->saveFavourite();
    }
}
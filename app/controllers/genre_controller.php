<?php

class GenreController extends BaseController {
    
    public static function find($id) {
        
        $bands = BandGenre::findbandsbygenre($id);
        $user = null;
        if ($_SESSION) {
            $user = $_SESSION['user'];
        }     
        
        foreach ($bands as $band) {
            $band->nextgig = Gig::findBandsNextGig($band->id);
            $band->genres = BandGenre::findgenresforband($band->id);
            $band->members = Member::findallbyband($band->id);
        }

        if ($bands == null) {
            Redirect::to("/", array('user' => $user));
        }  
        
        View::make('search_list.html', array('bands' => $bands, 'user' => $user));
    }
}
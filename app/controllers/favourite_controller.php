<?php

class FavouriteController extends BaseController {

    public static function favourites($id) {

        $favourites = Favourite::findAll($id);
        $user = null;
        if ($_SESSION) {
            $user = $_SESSION['user'];
        }
        
        foreach ($favourites as $band) {
            $band->nextgig = Gig::findBandsNextGig($band->id);
        }

        $band = Band::findwithid($id);
        View::make('favourite_list.html', array('band' => $band, 'favourites' => $favourites, 'user' => $user));
    }

    public static function newfavourite($id) {

        if ($_SESSION) {

            $favourite = new Favourite(array(
                'favourite' => $id,
                'band_id' => $_SESSION['user']
            ));

            $favourite->saveFavourite();
        }
        Redirect::to('/band/' . $id);
    }

    public static function delete($id) {

        if ($_SESSION) {
            $favourite = new Favourite(array(
                'favourite' => $id,
                'band_id' => $_SESSION['user']
            ));

            $favourite->deleteFavourite();
            Redirect::to('/favourites/' . $_SESSION['user']);
        } else {
            Redirect::to('/');
        }
    }

}

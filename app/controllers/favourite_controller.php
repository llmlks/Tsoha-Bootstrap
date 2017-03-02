<?php

class FavouriteController extends BaseController {

    public static function favourites($id) {

        $favourites = Favourite::find_all($id);
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        
        foreach ($favourites as $band) {
            $band->nextgig = Gig::find_bands_next_gig($band->id);
        }

        $band = Band::find_with_id($id);
        $admin = self::get_admin_logged_in();
        
        View::make('favourite_list.html', array('band' => $band, 'favourites' => $favourites, 'user' => $user, 'admin' => $admin));
    }

    public static function new_favourite($id) {

        if (isset($_SESSION['user'])) {

            $favourite = new Favourite(array(
                'favourite' => $id,
                'band_id' => $_SESSION['user']
            ));

            $favourite->save();
        }
        Redirect::to('/band/' . $id);
    }

    public static function delete($id) {

        if (isset($_SESSION['user'])) {
            $favourite = new Favourite(array(
                'favourite' => $id,
                'band_id' => $_SESSION['user']
            ));

            $favourite->delete();
            Redirect::to('/favourites/' . $_SESSION['user']);
        } else {
            Redirect::to('/');
        }
    }

}

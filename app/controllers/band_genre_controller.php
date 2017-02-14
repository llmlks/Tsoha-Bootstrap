<?php

class BandGenreController extends BaseController {

    public static function delete($id) {

        if (isset($_SESSION['user'])) {
            $bandgenre = new BandGenre(array(
                'genre_id' => $id,
                'band_id' => $_SESSION['user']
            ));

            $bandgenre->delete();
            Redirect::to('/band/' . $_SESSION['user'] . '/edit');
        } else {
            Redirect::to('/');
        }
    }

    public static function add($id) {
        
        if (isset($_SESSION['user'])) {
            $bandgenre = new BandGenre(array(
                'genre_id' => $id,
                'band_id' => $_SESSION['user']
            ));

            $bandgenre->save();
            Redirect::to('/band/' . $_SESSION['user'] . '/edit');
        } else {
            Redirect::to('/');
        }        
    }
}

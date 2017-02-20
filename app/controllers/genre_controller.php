<?php

class GenreController extends BaseController {

    public static function find($id) {

        $bands = BandGenre::find_bands_by_genre($id);
        $genres = Genre::find_all();
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        if ($bands) {
            foreach ($bands as $band) {
                $band->nextgig = Gig::find_bands_next_gig($band->id);
                $band->genres = BandGenre::find_genres_for_band($band->id);
                $band->members = Member::find_all_by_band($band->id);
            }
        }

        $message = "There were no matches to your search";

        View::make('search_list.html', array('genres' => $genres, 'bands' => $bands, 'user' => $user, 'message' => $message));
    }
}

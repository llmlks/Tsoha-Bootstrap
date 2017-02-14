<?php

class GenreController extends BaseController {

    public static function find($id) {

        $bands = BandGenre::findbandsbygenre($id);
        $genres = Genre::findall();
        $user = null;
        if ($_SESSION) {
            $user = $_SESSION['user'];
        }

        if ($bands) {
            foreach ($bands as $band) {
                $band->nextgig = Gig::findBandsNextGig($band->id);
                $band->genres = BandGenre::findgenresforband($band->id);
                $band->members = Member::findallbyband($band->id);
            }
        }

        $message = "There were no matches to your search";

        View::make('search_list.html', array('genres' => $genres, 'bands' => $bands, 'user' => $user, 'message' => $message));
    }
}

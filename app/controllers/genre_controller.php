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

        $admin = self::get_admin_logged_in();
        $message = "There were no matches to your search";

        View::make('search_list.html', array('genres' => $genres, 'bands' => $bands, 'user' => $user, 'message' => $message, 'admin' => $admin));
    }
    
    public static function manage_genres() {
        
        $genres = Genre::find_all();
                
        View::make('admin_genres.html', array('genres' => $genres, 'admin' => $_SESSION['admin']));
    }
    
    public static function add_genre() {
        
        $genrename = $_POST['genrename'];
        
        $genre = new Genre(array('genrename' => $genrename));
        $errors = $genre->errors();

        $genres = Genre::find_all();
        
        if (count($errors) > 0) {
            View::make('admin_genres.html', array('genres' => $genres, 'admin' => $_SESSION['admin'], 'genrename' => $genrename, 'errors' => $errors));
        } else {
            $genre->save();
            Redirect::to('/genres');
        }
    }
    
    public static function delete_genre($id) {
        
        $genre = new Genre(array('id' => $id));
        $genre->delete();
        
        Redirect::to('/genres');
    }
}

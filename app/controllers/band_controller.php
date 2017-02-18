<?php

class BandController extends BaseController {

    public static function sandbox() {

        $band = new Band(array(
            'bandname' => 'Punk4life',
            'description' => 'Bringing joy to the world',
            'origin' => 'Brisbane, Australia',
            'username' => 'punk',
            'password' => 'fourlife'
        ));

        $gig = new Gig(array(
            'band_id' => 1,
            'time' => '8.00',
            'date' => '23.03.2016',
            'location' => ''
        ));

        $bands = BandGenre::findbandsbygenre(1);
        Kint::dump($band->errors());
        Kint::dump($gig->errors());
        Kint::dump($bands);
    }

    public static function band_show($id) {

        $band = Band::findwithid($id);
        $genres = BandGenre::findgenresforband($id);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);
        $links = BandLink::findAllByBand($id);
        $in_favourites = false;
        $user = false;
        if (isset($_SESSION['user'])) {
            $in_favourites = Favourite::isInFavourites($id);
            $user = $_SESSION['user'];
        }

        $voted = false;
        if (isset($_SESSION[$band->bandname])) {
            $voted = $_SESSION[$band->bandname];
        }

        View::make('band_show.html', array(
            'band' => $band,
            'genres' => $genres,
            'members' => $members,
            'gigs' => $gigs,
            'links' => $links,
            'in_favourites' => $in_favourites,
            'user' => $user,
            'voted' => $voted
        ));
    }

    public static function searchWithName() {

        $search = $_POST["search"];
        $bands = Band::findwithname($search);
        $genres = Genre::findall();
        $user = null;
        if (isset($_SESSION['user'])) {
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

    public static function signup() {

        View::make('signup.html');
    }

    public static function newband() {
        $params = $_POST;

        $attributes = array(
            'bandname' => $params['bandname'],
            'description' => $params['description'],
            'origin' => $params['origin'],
            'username' => $params['username'],
            'password' => $params['password']
        );

        $band = new Band($attributes);
        $errors = $band->errors();

        if (count($errors) > 0) {
            View::make('signup.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $band->save();

            Redirect::to('/login', array('message' => 'Your have successfully registered and can now log in with your username and password. Welcome!'));
        }
    }

    public static function home() {

        $page = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $band_count = Band::count();
        $pages = ceil($band_count / 10);

        $bands = Band::findall($page);
        $genres = Genre::findall();

        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        foreach ($bands as $band) {
            $band->genres = BandGenre::findgenresforband($band->id);
        }

        View::make('home.html', array('pages' => $pages, 'bands' => $bands, 'user' => $user, 'genres' => $genres));
    }

    public static function edit() {

        $band = self::get_user_logged_in();
        $id = $band->id;
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);
        $links = BandLink::findAllByBand($id);
        $genres = BandGenre::findgenresexcludingbands($id);
        $bandgenres = BandGenre::findgenresforband($id);

        View::make('band_edit.html', array('bandgenres' => $bandgenres, 'links' => $links, 'band' => $band, 'members' => $members, 'gigs' => $gigs, 'user' => $id, 'genres' => $genres));
    }

    public static function update() {

        $params = $_POST;
        $user = self::get_user_logged_in();
        $id = $user->id;
        $attributes = array(
            'id' => $id,
            'bandname' => $params['name'],
            'description' => $params['description'],
            'origin' => $params['origin'],
            'username' => $user->username,
            'password' => $user->password
        );
        $band = new Band($attributes);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);
        $links = BandLink::findAllByBand($id);
        $genres = Genre::findall();
        $error = $band->validate_name();

        if ($error) {
            View::make('band_edit.html', array('error' => $error, 'links' => $links, 'band' => $band, 'members' => $members, 'gigs' => $gigs, 'user' => $id, 'genres' => $genres));
        } else {
            $band->update($attributes);

            Redirect::to('/band/' . $id, array('message' => 'Your band\'s information has been updated', 'user' => $id));
        }
    }

    public static function upvote($id) {

        $band = Band::findwithid($id);
        Band::upvote($id);
        $_SESSION[$band->bandname] = true;
        Redirect::to('/band/' . $id);
    }

    public static function downvote($id) {

        $band = Band::findwithid($id);
        Band::downvote($id);
        $_SESSION[$band->bandname] = false;
        Redirect::to('/band/' . $id);
    }

    public static function delete() {

        $band = self::get_user_logged_in();
        $band->delete($band->id);

        session_unset();

        session_destroy();

        Redirect::to('/');
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'You have successfully logged out'));
    }

    public static function login() {
        View::make('login.html');
    }

    public static function handle_login() {

        $params = $_POST;

        $user = Band::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('login.html', array('error' => 'Invalid username or password', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!', 'user' => $_SESSION['user']));
        }
    }

    public static function band_edit() {

        View::make('suunnitelmat/band_edit.html');
    }

    public static function sband_show() {

        View::make('suunnitelmat/band_show.html');
    }

    public static function bandmember_add() {

        View::make('suunnitelmat/bandmember_add.html');
    }

    public static function bandmember_edit() {

        View::make('suunnitelmat/bandmember_edit.html');
    }

    public static function concert_add() {

        View::make('suunnitelmat/concert_add.html');
    }

    public static function concert_edit() {

        View::make('suunnitelmat/concert_edit.html');
    }

    public static function favourite() {

        View::make('suunnitelmat/favourite_list.html');
    }

    public static function shome() {

        View::make('suunnitelmat/home.html');
    }

    public static function slogin() {

        View::make('suunnitelmat/login.html');
    }

    public static function search() {

        View::make('suunnitelmat/search_list.html');
    }

    public static function ssignup() {

        View::make('suunnitelmat/signup.html');
    }

}

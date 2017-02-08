<?php

class BandController extends BaseController {

    public static function band_show($id) {

        $band = Band::findwithid($id);
        $genres = BandGenre::findgenresforband($id);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);
        $links = BandLink::findAllByBand($id);
        $in_favourites = false;
        $user = false;
        if ($_SESSION) {
            $in_favourites = Favourite::isInFavourites($id);
            $user = $_SESSION['user'];
        }

        View::make('band_show.html', array(
            'band' => $band,
            'genres' => $genres,
            'members' => $members,
            'gigs' => $gigs,
            'links' => $links,
            'in_favourites' => $in_favourites,
            'user' => $user
        ));
    }

    public static function searchWithName() {

        $bands = Band::findwithname($_POST["search"]);
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
            View::make('signup.html', array('errors' => $errors, 'attributes' => $attributes, 'user' => $_SESSION['user']));
        } else {
            $band->save();

            Redirect::to('/login', array('message' => 'Your have now successfully registered and can now log in with your username and password. Welcome!', 'user' => $_SESSION['user']));
        }
    }

    public static function home() {

        $bands = Band::findall();
        $user = null;
        if ($_SESSION) {
            $user = $_SESSION['user'];
        }

        foreach ($bands as $band) {
            $band->genres = BandGenre::findgenresforband($band->id);
        }

        View::make('home.html', array('bands' => $bands, 'user' => $user));
    }

    public static function edit() {

        $id = $_SESSION['user'];
        $band = Band::findwithid($id);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);

        View::make('band_edit.html', array('band' => $band, 'members' => $members, 'gigs' => $gigs, 'user' => $_SESSION['user']));
    }

    public static function update() {

        $params = $_POST;
        $attributes = array(
            'id' => $_SESSION['user'],
            'bandname' => $params['name'],
            'description' => $params['description'],
            'origin' => $params['origin']
        );
        $band = new Band($attributes);
        $errors = $band->errors();

        if (count($errors) > 0) {
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes, 'user' => $_SESSION['user']));
        } else {
            $band->update($attributes);

            Redirect::to('/band/' . $_SESSION['user'], array('message' => 'Your band\'s information has been updated', 'user' => $_SESSION['user']));
        }
    }

    public static function delete($id) {
        
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

}

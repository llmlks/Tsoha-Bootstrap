<?php

class BandController extends BaseController {

    public static function band_show($id) {

        $band = Band::findwithid($id);
        $genres = BandGenre::findgenresforband($id);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);
        $links = BandLink::findAllByBand($id);

        View::make('band_show.html', array(
            'band' => $band,
            'genres' => $genres,
            'members' => $members,
            'gigs' => $gigs,
            'links' => $links
        ));
    }

    public static function searchWithName() {

        $bands = Band::findwithname($_POST["search"]);
        
        foreach ($bands as $band) {
            $band->nextgig = Gig::findBandsNextGig($band->id);
            $band->genres = BandGenre::findgenresforband($band->id);
            $band->members = Member::findallbyband($band->id);
        }

        if ($bands == null) {
            Redirect::to("/");
        }

        View::make('search_list.html', array('bands' => $bands));
    }

    public static function signup() {

        View::make('signup.html');
    }

    public static function newband() {
        $params = $_POST;

        $band = new Band(array(
            'bandname' => $params['bandname'],
            'description' => $params['description'],
            'origin' => $params['origin'],
            'username' => $params['username'],
            'password' => $params['password']
        ));

        $band->save();
        $id = $band->id;

        Redirect::to('/band/' . $id);
    }

    public static function home() {

        $bands = Band::findall();
        
        foreach ($bands as $band) {
            $band->genres = BandGenre::findgenresforband($band->id);
        }

        View::make('home.html', array('bands' => $bands));
    }

    public static function edit($id) {

        $band = Band::findwithid($id);
        $members = Member::findallbyband($id);
        $gigs = Gig::findAllByBand($id);

        View::make('band_edit.html', array('band' => $band, 'members' => $members, 'gigs' => $gigs));
    }

    public static function update($id) {

        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'bandname' => $params['name'],
            'description' => $params['description'],
            'origin' => $params['origin']
        );
        $band = new Band($attributes);
        $errors = $band->errors();

        if (count($errors) > 0) {
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $band->update($attributes);

            Redirect::to('/band/' . $id, array('message' => 'Your band\'s information has been updated'));
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
            View::make('login.html', array('error' => 'Wrong username or password', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!'));
        }
    }

}

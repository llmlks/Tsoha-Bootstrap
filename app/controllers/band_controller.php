<?php

class BandController extends BaseController {

    public static function band_show($id) {

        $band = Band::findwithid($id);

        View::make('band_show.html', array('band' => $band));
    }

    public static function favourites($id) {

        $favourites = Band::favourites($id);

        View::make('favourite_list.html', array('favourites' => $favourites));
    }

    public static function searchWithName() {

        $bands = Band::findwithname($_POST["search"]);

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

        View::make('home.html', array('bands' => $bands));
    }

    public static function edit($id) {

        $band = Band::findwithid($id);

        View::make('band_edit.html', array('attributes' => $band));
    }

    public static function update($id) {

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
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $band->update();
            
            Redirect::to('/band/' . $id, array('message' => 'Your band\'s information details have been updated'));
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

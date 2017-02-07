<?php

class UserController extends BaseController {

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function handle_login() {

        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('suunnitelmat/login.html', array('error' => 'Wrong username or password', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!'));
        }
    }

}

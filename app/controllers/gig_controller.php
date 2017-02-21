<?php

class GigController extends BaseController {

    public static function add() {
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        View::make('concert_add.html', array('user' => $user));
    }

    public static function new_gig($id) {

        $params = $_POST;
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        $attributes = array(
            'band_id' => $id,
            'time' => $params['time'],
            'date' => $params['date'],
            'location' => $params['location']
        );

        $gig = new Gig($attributes);
        $errors = $gig->errors();

        if (count($errors) > 0) {
            View::make('concert_add.html', array('errors' => $errors, 'attributes' => $attributes, 'user' => $user));
        } else {
            $gig->save();
            Redirect::to('/band/' . $id . '/edit');
        }
    }

    public static function edit($id) {

        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        $gig = Gig::find_with_id($id);

        View::make('concert_edit.html', array('gig' => $gig, 'user' => $user));
    }

    public static function update($id) {

        $params = $_POST;

        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        $attributes = array(
            'id' => $id,
            'band_id' => $_SESSION['user'],
            'time' => $params['time'],
            'date' => $params['date'],
            'location' => $params['location'],
        );
        $gig = new Gig($attributes);
        $errors = $gig->errors();

        if (count($errors) > 0) {
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes, 'user' => $user));
        } else {
            $gig->update($attributes);

            Redirect::to('/band/' . $_SESSION['user'] . '/edit');
        }
    }

    public static function delete($id) {

        $gig = new Gig(array('id' => $id));
        $gig->delete($id);

        Redirect::to('/band/' . $_SESSION['user'] . '/edit');
    }

}

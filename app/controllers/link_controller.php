<?php

class LinkController extends BaseController {

    public static function add() {
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        View::make('link_add.html', array('user' => $user));
    }

    public static function newLink($id) {

        $params = $_POST;
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        $attributes = array(
            'band_id' => $user,
            'linkname' => $params['linkname'],
            'url' => $params['url']
        );

        $link = new BandLink($attributes);

        $errors = $link->errors();

        if (count($errors) > 0) {
            View::make('link_add.html', array('user' => $user, 'errors' => $errors, 'attributes' => $attributes));
        } else {
            $link->save();
            Redirect::to('/band/' . $id . '/edit');
        }
    }

    public static function delete($id) {

        $link = new BandLink(array('id' => $id));
        $link->delete();

        Redirect::to('/band/' . $_SESSION['user'] . '/edit');
    }

}

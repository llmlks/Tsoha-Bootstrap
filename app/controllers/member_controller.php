<?php

class MemberController extends BaseController {

    public static function add() {

        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        View::make('bandmember_add.html', array('user' => $user));
    }

    public static function newMember($id) {

        $params = $_POST;
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        $attributes = array(
            'band_id' => $id,
            'membername' => $params['name'],
            'instruments' => $params['instruments'],
            'joined' => $params['joined'],
            'resigned' => $params['resigned']
        );
        $member = new Member($attributes);
        $errors = $member->errors();

        if (count($errors) > 0) {
            View::make('bandmember_add.html', array('user' => $user, 'attributes' => $attributes, 'user' => $user, 'errors' => $errors));
        } else {
            $member->save();
            Redirect::to('/band/' . $id . '/edit');
        }
    }

    public static function edit($id) {

        $member = Member::findwithid($id);

        View::make('bandmember_edit.html', array('member' => $member));
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
            'membername' => $params['name'],
            'instruments' => $params['instruments'],
            'joined' => $params['joined'],
            'resigned' => $params['resigned']
        );
        $member = new Member($attributes);
        $errors = $member->errors();

        if (count($errors) > 0) {
            View::make('bandmember_edit.html', array('errors' => $errors, 'attributes' => $attributes, 'user' => $user));
        } else {
            $member->update($attributes);

            Redirect::to('/band/' . $_SESSION['user'] . '/edit');
        }
    }

    public static function delete($id) {

        $member = new Member(array('id' => $id));
        $member->delete();

        Redirect::to('/band/' . $_SESSION['user'] . '/edit');
    }

}

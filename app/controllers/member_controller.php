<?php

class MemberController extends BaseController {
    
    public static function add($id) {

        View::make('bandmember_add.html');
    }    
    
    public static function newMember($id) {
        
        $params = $_POST;
        
        $member = new Member(array(
            'band_id' => $id,
            'membername' => $params['name'],
            'instruments' => $params['instruments'],
            'joined' => $params['joined'],
            'resigned' => $params['resigned']
        ));
        
        $member->save();
        Redirect::to('/band/' . $id . '/edit');
    }
    
    public static function edit($id) {
        
        $member = Member::findwithid($id);
        
        View::make('bandmember_edit.html', array('member' => $member));
    }
    
    public static function update($id) {

        $params = $_POST;
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
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes));
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
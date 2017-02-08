<?php

class GigController extends BaseController {
    
    public static function add() {

        View::make('concert_add.html', array('user' => $_SESSION['user']));
    }    
    
    public static function newGig($id) {
        
        $params = $_POST;
        
        $gig = new Gig(array(
            'band_id' => $id,
            'time' => $params['time'],
            'date' => $params['date'],
            'location' => $params['location']
        ));
        
        $gig->save();
        Redirect::to('/band/' . $id . '/edit');
    }
    
    public static function edit($id) {
        
        $gig = Gig::findwithid($id);
        
        View::make('concert_edit.html', array('gig' => $gig));
    }
    
    public static function update($id) {

        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'band_id' => $_SESSION['user'],
            'time' => $params['time'],
            'date' => $params['date'],
            'location' => $params['location'],
        );
        $gig = new Gig($attributes);
        $errors = array();

        if (count($errors) > 0) {
            View::make('band_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $gig->update($attributes);

            Redirect::to('/band/' . $_SESSION['user'] . '/edit');
        }
    }
    
    public static function delete($id) {
        
        $gig = new Gig(array('id' => $id));
        $gig->delete();
        
        Redirect::to('/band/' . $_SESSION['user'] . '/edit');
    }
}
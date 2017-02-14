<?php

  class HelloWorldController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('home.html');
    }

    public static function sandbox(){

        $band = new Band(array(
            'bandname' => 'b',
            'description' => '',
            'origin' => '',
            'username' => '',
            'pas;sword' => '1'
        ));
        
        $gig = new Gig(array(            
            'band_id' => 1,
            'time' => '8.00',
            'date' => '23.03.2016',
            'location' => ''
        ));
        Kint::dump($band->errors());
        Kint::dump($gig->errors());

    }
    
    public static function home(){
        View::make('suunnitelmat/home.html');
    }

    public static function band_show(){
        View::make('suunnitelmat/band_show.html');
    }

    public static function bandmember_add(){
        View::make('suunnitelmat/bandmember_add.html');
    }

    public static function bandmember_edit(){
        View::make('suunnitelmat/bandmember_edit.html');
    }

    public static function concert_add(){
        View::make('suunnitelmat/concert_add.html');
    }    

    public static function concert_edit(){
        View::make('suunnitelmat/concert_edit.html');
    }

    public static function favourite_list(){
        View::make('suunnitelmat/favourite_list.html');
    }

    public static function signup(){
        View::make('suunnitelmat/signup.html');
    }

    public static function login(){
        View::make('suunnitelmat/login.html');
    }    
    
    public static function search_list(){
        View::make('suunnitelmat/search_list.html');
    }    

    public static function band_edit(){
        View::make('suunnitelmat/band_edit.html');
    }    
  }

<?php

  class HelloWorldController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('home.html');
    }

    public static function sandbox(){
        View::make('helloworld.html');
    }
    
    public static function home(){
        View::make('sunnitelmat/home.html');
    }

    public static function band_show(){
        View::make('sunnitelmat/band_show.html');
    }

    public static function bandmember_add(){
        View::make('sunnitelmat/bandmember_add.html');
    }

    public static function bandmember_edit(){
        View::make('sunnitelmat/bandmember_edit.html');
    }

    public static function concert_add(){
        View::make('sunnitelmat/concert_add.html');
    }    

    public static function concert_edit(){
        View::make('sunnitelmat/concert_edit.html');
    }

    public static function favourite_list(){
        View::make('sunnitelmat/favourite_list.html');
    }

    public static function signup(){
        View::make('sunnitelmat/signup.html');
    }

    public static function login(){
        View::make('sunnitelmat/login.html');
    }    
    
    public static function search_list(){
        View::make('sunnitelmat/search_list.html');
    }    

    public static function band_edit(){
        View::make('sunnitelmat/band_edit.html');
    }    
  }

<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });  
  
  $routes->get('/band', function() {
    HelloWorldController::band_show();
  });
  
  $routes->get('/band_edit', function() {
    HelloWorldController::band_edit();
  });

  $routes->get('/search', function() {
    HelloWorldController::search_list();
  });

  $routes->get('/home', function() {
    HelloWorldController::home();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/signup', function() {
    HelloWorldController::signup();
  });

  $routes->get('/bandmember_add', function() {
    HelloWorldController::bandmember_add();
  });

  $routes->get('/bandmember_edit', function() {
    HelloWorldController::bandmember_edit();
  });

  $routes->get('/concert_add', function() {
    HelloWorldController::concert_add();
  });

  $routes->get('/concert_edit', function() {
    HelloWorldController::concert_edit();
  });

  $routes->get('/favourites', function() {
    HelloWorldController::favourite_list();
  });  

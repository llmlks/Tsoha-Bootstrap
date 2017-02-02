<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/band_edit', function() {
    HelloWorldController::band_edit();
});

$routes->get('/search', function() {
    BandController::search_list();
});

$routes->get('/', function() {
    HelloWorldController::home();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/signup', function() {
    BandController::signup();
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

$routes->get('/favourites/:id', function($id) {
    BandController::favourites($id);
});

$routes->get('/band/:id', function($id) {
    BandController::band_show($id);
});

$routes->post('/signup', function() {
    BandController::newband();
});

$routes->post('/', function() {
    BandController::searchWithName();
});

$routes->post('/search', function() {
    BandController::searchWithName();
});
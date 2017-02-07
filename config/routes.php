<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/static/band_edit', function() {
    HelloWorldController::band_edit();
});

$routes->get('/static/bandmember_add', function() {
    HelloWorldController::bandmember_add();
});

$routes->get('/static/bandmember_edit', function() {
    HelloWorldController::bandmember_edit();
});

$routes->get('/static/concert_add', function() {
    HelloWorldController::concert_add();
});

$routes->get('/static/concert_edit', function() {
    HelloWorldController::concert_edit();
});

$routes->get('/static/band_show', function() {
    HelloWorldController::band_show();
});

$routes->get('/static/favourite_list', function() {
    HelloWorldController::favourite_list();
});

$routes->get('/static/home', function() {
    HelloWorldController::home();
});

$routes->get('/static/login', function() {
    HelloWorldController::login();
});

$routes->get('/static/search_list', function() {
    HelloWorldController::search_list();
});

$routes->get('/static/signup', function() {
    HelloWorldController::signup();
});

$routes->get('/', function() {
    BandController::home();
});

$routes->post('/', function() {
    BandController::searchWithName();
});

$routes->get('/login', function() {
    BandController::login();
});

$routes->post('/login', function() {
    BandController::handle_login();
});

$routes->get('/signup', function() {
    BandController::signup();
});

$routes->post('/signup', function() {
    BandController::newband();
});

$routes->get('/favourites/:id', function($id) {
    BandController::favourites($id);
});

$routes->get('/band/:id', function($id) {
    BandController::band_show($id);
});

$routes->get('/search', function() {
    BandController::search_list();
});

$routes->post('/search', function() {
    BandController::searchWithName();
});

$routes->get('/band/edit/:id', function($id) {
    BandController::edit($id);
});

$routes->post('/band/edit/:id', function($id) {
    BandController::update($id);
});
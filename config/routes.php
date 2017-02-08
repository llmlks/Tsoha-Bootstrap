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

$routes->get('/search', function() {
    BandController::search_list();
});

$routes->post('/search', function() {
    BandController::searchWithName();
});

$routes->get('/band/:id/edit', function() {
    BandController::edit();
});

$routes->post('/band/:id/edit', function() {
    BandController::update();
});

$routes->get('/band/:id/delete', function() {
    BandController::delete();
});

$routes->post('/band/:id/to_favourites', function($id) {
    FavouriteController::newfavourite($id);
});

$routes->get('/favourites/:id', function($id) {
    FavouriteController::favourites($id);
});

$routes->get('/favourite/:id/delete', function($id) {
    FavouriteController::delete($id);
});

$routes->get('/member/:id/edit', function($id) {
    MemberController::edit($id);
});

$routes->post('/member/:id/edit', function($id) {
    MemberController::update($id);
});

$routes->get('/member/:id/delete', function($id) {
    MemberController::delete($id);
});

$routes->get('/band/:id/newmember', function() {
    MemberController::add();
});

$routes->post('/band/:id/newmember', function($id) {
    MemberController::newMember($id);
});

$routes->get('/gig/:id/edit', function($id) {
    GigController::edit($id);
});

$routes->post('/gig/:id/edit', function($id){
    GigController::update($id);
});

$routes->get('/gig/:id/delete', function($id) {
    GigController::delete($id);
});

$routes->get('/band/:id/newgig', function() {
    GigController::add();
});

$routes->post('/band/:id/newgig', function($id) {
    GigController::newGig($id);
});

$routes->get('/band/:id', function($id) {
    BandController::band_show($id);
});

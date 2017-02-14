<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

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

$routes->get('/band/:id/edit', 'check_logged_in', function() {
    BandController::edit();
});

$routes->post('/band/:id/edit', 'check_logged_in', function() {
    BandController::update();
});

$routes->get('/band/:id/delete', 'check_logged_in', function() {
    BandController::delete();
});

$routes->get('/logout', 'check_logged_in', function() {
    BandController::logout();
});

$routes->post('/band/:id/to_favourites', 'check_logged_in', function($id) {
    FavouriteController::newfavourite($id);
});

$routes->get('/favourites/:id', function($id) {
    FavouriteController::favourites($id);
});

$routes->get('/favourite/:id/delete', 'check_logged_in', function($id) {
    FavouriteController::delete($id);
});

$routes->get('/member/:id/edit', 'check_logged_in', function($id) {
    MemberController::edit($id);
});

$routes->post('/member/:id/edit', 'check_logged_in', function($id) {
    MemberController::update($id);
});

$routes->get('/member/:id/delete', 'check_logged_in', function($id) {
    MemberController::delete($id);
});

$routes->get('/band/:id/newmember', 'check_logged_in', function() {
    MemberController::add();
});

$routes->post('/band/:id/newmember', 'check_logged_in', function($id) {
    MemberController::newMember($id);
});

$routes->get('/gig/:id/edit', 'check_logged_in', function($id) {
    GigController::edit($id);
});

$routes->post('/gig/:id/edit', 'check_logged_in', function($id){
    GigController::update($id);
});

$routes->get('/gig/:id/delete', 'check_logged_in', function($id) {
    GigController::delete($id);
});

$routes->get('/band/:id/newgig', 'check_logged_in', function() {
    GigController::add();
});

$routes->post('/band/:id/newgig', 'check_logged_in', function($id) {
    GigController::newGig($id);
});

$routes->get('/band/:id/newlink', 'check_logged_in', function() {
    LinkController::add();
});

$routes->post('/band/:id/newlink', 'check_logged_in', function($id) {
    LinkController::newLink($id);
});

$routes->get('/bandlink/:id/delete', 'check_logged_in', function($id) {
    LinkController::delete($id);
});

$routes->get('/genre_search/:id', function($id) {
    GenreController::find($id);
});

$routes->get('/bandgenre/:id/delete', 'check_logged_in', function($id) {
    BandGenreController::delete($id);
});

$routes->get('/bandgenre/:id/add', 'check_logged_in', function($id) {
    BandGenreController::add($id);
});

$routes->get('/band/:id', function($id) {
    BandController::band_show($id);
});

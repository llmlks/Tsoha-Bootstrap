<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

$routes->get('/hiekkalaatikko', function() {
    BandController::sandbox();
});

$routes->get('/suunnitelmat/bedit', function() {
    BandController::band_edit();
});

$routes->get('/suunnitelmat/bshow', function() {
    BandController::sband_show();
});

$routes->get('/suunnitelmat/bmadd', function() {
    BandController::bandmember_add();
});

$routes->get('/suunnitelmat/bmedit', function() {
    BandController::bandmember_edit();
});

$routes->get('/suunnitelmat/cadd', function() {
    BandController::concert_add();
});

$routes->get('/suunnitelmat/cedit', function() {
    BandController::concert_edit();
});

$routes->get('/suunnitelmat/flist', function() {
    BandController::favourite();
});

$routes->get('/suunnitelmat/home', function() {
    BandController::shome();
});

$routes->get('/suunnitelmat/login', function() {
    BandController::slogin();
});

$routes->get('/suunnitelmat/search', function() {
    BandController::search();
});

$routes->get('/suunnitelmat/signup', function() {
    BandController::ssignup();    
});

$routes->get('/', function() {
    BandController::home();
});

$routes->post('/', function() {
    BandController::search_with_name();
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
    BandController::new_band();
});

$routes->get('/search', function() {
    BandController::search_list();
});

$routes->post('/search', function() {
    BandController::search_with_name();
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

$routes->get('/band/:id/upvote', function($id) {
    BandController::upvote($id);
});

$routes->get('/band/:id/downvote', function($id) {
    BandController::downvote($id);
});

$routes->post('/band/:id/to_favourites', 'check_logged_in', function($id) {
    FavouriteController::new_favourite($id);
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
    MemberController::new_member($id);
});

$routes->get('/gig/:id/edit', 'check_logged_in', function($id) {
    GigController::edit($id);
});

$routes->post('/gig/:id/edit', 'check_logged_in', function($id) {
    GigController::update($id);
});

$routes->get('/gig/:id/delete', 'check_logged_in', function($id) {
    GigController::delete($id);
});

$routes->get('/band/:id/newgig', 'check_logged_in', function() {
    GigController::add();
});

$routes->post('/band/:id/newgig', 'check_logged_in', function($id) {
    GigController::new_gig($id);
});

$routes->get('/band/:id/newlink', 'check_logged_in', function() {
    LinkController::add();
});

$routes->post('/band/:id/newlink', 'check_logged_in', function($id) {
    LinkController::new_link($id);
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

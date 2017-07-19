<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

// Auth
$app->post('/auth/signup', 'AuthController@signup');
$app->post('/auth/login', 'AuthController@login');
$app->post('/auth/logout', 'AuthController@logout');
$app->post('/auth/forgot', 'AuthController@forgotRequest');
$app->post('/auth/forgot/{token}', 'AuthController@forgotChange');

// User
$app->get('/user', 'UserController@get');
$app->get('/user/{id}', 'UserController@get');
$app->post('/user', 'UserController@update');

// Meta stuff
$app->get('/stats', 'MetaController@stats');

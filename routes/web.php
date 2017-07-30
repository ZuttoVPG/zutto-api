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

// OAuth2 provider -- see https://github.com/dusterio/lumen-passport#installed-routes
Dusterio\LumenPassport\LumenPassport::routes($app);

// Steal the token endpoint & replace it with the zutto wrapper
$app->group(['prefix' => 'oauth'], function () use ($app) {
    $app->post('/token', 'AuthController@issueTokenZutto');
});

// Move these to user too probably 
$app->post('/auth/forgot', 'AuthController@forgotRequest');
$app->post('/auth/forgot/{token}', 'AuthController@forgotChange');

// User
$app->put('/user', 'UserController@create');

$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('/user', 'UserController@get');
    $app->get('/user/{id}', 'UserController@get');
    $app->post('/user', 'UserController@update');
});

// Meta stuff
$app->get('/stats', 'MetaController@stats');

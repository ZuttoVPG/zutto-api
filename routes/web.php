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

$router->get('/', function () use ($router) {
    return "ZuttoZuttoZutto API v0.0.0-indev"; 
});

// OAuth2 provider -- see https://github.com/dusterio/lumen-passport#installed-routes
Dusterio\LumenPassport\LumenPassport::routes($router);

// Steal the token endpoint & replace it with the zutto wrapper
$router->group(['prefix' => 'oauth'], function () use ($router) {
    $router->post('/token', 'AuthController@issueTokenZutto');
});

// Unauthed signup/user management operations 
$router->put('/user', 'UserController@create');
$router->post('/auth/forgot', 'AuthController@forgotRequest');
$router->post('/auth/forgot/{token}', 'AuthController@forgotChange');

// Authenticated stuff
$router->group(['middleware' => 'auth'], function () use ($router) {
    // Self management
    $router->get('/user', 'UserController@get');
    $router->post('/user', 'UserController@update');

    // User lookup
    $router->get('/user/{id}', 'UserController@get');

    // Email Verification
    $router->post('/verify/resend', 'VerifyController@resend');
    $router->post('/verify/{token}', 'VerifyController@verify');
});

// Meta stuff
$router->get('/stats', 'MetaController@stats');

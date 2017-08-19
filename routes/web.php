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

// Unauthed signup/user management operations 
$app->put('/user', 'UserController@create');
$app->post('/auth/forgot', 'AuthController@forgotRequest');
$app->post('/auth/forgot/{token}', 'AuthController@forgotChange');

// Authenticated stuff
$app->group(['middleware' => 'auth'], function () use ($app) {
    // Self management
    $app->get('/user', 'UserController@get');
    $app->post('/user', 'UserController@update');

    // User lookup
    $app->get('/user/{id}', 'UserController@get');

    // Email Verification
    $app->post('/verify/resend', 'VerifyController@resend');
    $app->post('/verify/{token}', 'VerifyController@verify');
});

// Meta stuff
$app->get('/stats', 'MetaController@stats');

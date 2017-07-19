<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'birth_date' => '1975-01-01',
        'tos_accept' => true,
        'registered_ip' => '127.0.0.1',
        'last_access_ip' => '127.0.0.1',

        // This is 'pwpwpwpw'
        'password_hash' => '2d613f753bfe8fc36b94418c2b14bcc8146e68687e37e8fb6f4820d87b7f8967',
        'password_salt' => '070f32e2e3ccb0439f7c162cd56f0dcf36815f0eaf77c99517db21a9739d96ac',
    ];
});

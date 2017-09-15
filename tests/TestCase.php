<?php

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Mail;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected $user;
    public function setUp()
    {
        parent::setUp();

        $this->artisan("db:seed");
        $this->user = factory('App\Models\User')->create();

        // If you're using this as a dev env, you might have Apache as the owner on the files for the default location.
        Passport::loadKeysFrom(storage_path('phpunit_passport_tokens'));

        // Don't send emails!
        Mail::fake();
    } // end setUp
}

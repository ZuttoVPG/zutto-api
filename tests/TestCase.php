<?php

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;
// use Laravel\Lumen\Testing\DatabaseTransactions;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseMigrations;
    // use DatabaseTransactions;

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
        $secondary_key_dir = storage_path('phpunit_passport_tokens');
        if (file_exists("${secondary_key_dir}/oauth-private.key") == true) {
            Passport::loadKeysFrom($secondary_key_dir);
        }

        // Don't send emails!
        Mail::fake();
    } // end setUp
}

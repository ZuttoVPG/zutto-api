<?php

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
    } // end setUp
}

<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class RollTableTest extends TestCase
{
    use DatabaseMigrations;
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->user = factory('App\Models\User')->create();
    } // end setUp

    public function testGet()
    {
        $resp = $this->actingAs($this->user)->json('GET', '/config/rollTable/1');
        $resp->assertResponseOk();

        $resp->seeJsonStructure(['id', 'tiers']); 
    } // end testGet

    public function testRoll()
    {
        $resp = $this->actingAs($this->user)->json('GET', 'config/rollTable/test/1');
        $resp->assertResponseOk();

        $resp->seeJsonStructure(['seed', 'prizes', 'log']);
    } // end testRoll

} // end RollTableTest 

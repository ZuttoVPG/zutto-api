<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class RollTableTest extends TestCase
{
    use DatabaseMigrations;

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

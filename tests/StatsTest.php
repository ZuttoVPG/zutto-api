<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    use DatabaseMigrations;

    public function testStats()
    {
        $resp = $this->json('GET', '/stats');

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['users']);
    } // end testSignup
} // end StatsTest

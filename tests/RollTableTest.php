<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RollTableTest extends TestCase
{
    use DatabaseMigrations;

    public function testGet()
    {
        // load one in
         
        $resp = $this->json('GET', '/config/drop-table/1');
        $resp->assertResponseOk();

        $resp->seeJsonStructure(['table' => ['tiers' => ['objects']]]);
    } // end testGet

} // end RollTableTest 

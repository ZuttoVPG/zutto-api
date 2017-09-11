<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class PetTypeTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testTypes()
    {
        $resp = $this->actingAs($this->user)->json('GET', '/petType');

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['*' => ['id', 'default_skin' => ['image']]]);
    } // end testTypes

    public function testType()
    {
        $resp = $this->actingAs($this->user)->json('GET', '/petType/1');

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'default_skin' => ['image']]);
    } // end testTypes
} // end RollTableTest

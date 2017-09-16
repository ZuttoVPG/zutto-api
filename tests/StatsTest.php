<?php

class StatsTest extends TestCase
{
    public function testStats()
    {
        $resp = $this->json('GET', '/stats');

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['users']);
    } // end testSignup
} // end StatsTest

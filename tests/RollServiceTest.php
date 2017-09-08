<?php

use App\Mail\EmailVerify;
use App\Support\Facades\Captcha;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RollServiceTest extends TestCase
{
    // use DatabaseMigrations;

    public function testFactory()
    {
        $table = 'some kinda mock';
        $service = RollService::factory($table);

        $this->assertInstanceOf(RollService::class, $service);
    } // end testSomething

    public function testValidation()
    {
        $table = 'some kinda mock';
        $good = RollService::factory($table);
        $this->assertTrue($good->isValid());

        $table = 'some kinda mock';
        $bad = RollService::factory($table);
        $this->assertFalse($bad->isValid());
    } // end testValidation

    public function testRoll()
    {
        $table = 'some kinda mock';
        $service = RollService::factory($table);

        $result = $service->roll();
        $this->assertInstanceOf(RollResult::class, $result);

        $this->assertGreaterThan(0, sizeof($result->getObjects()));
        $this->assertContainsOnlyInstancesOf(Skill::class, $result->getObjects());
    } // end testRoll

    public function testReproducableRoll()
    {
        $table = 'some kinda mock';
        $service = RollService::factory($table);

        $first_roll = $service->roll();

        $service = RollService::factory($table);
        $service->setSeed($first_roll->getSeed());
        $second_roll = $service->roll();

        $this->assertEquals($first_roll, $second_roll);
    } // end testReproducableRoll
} // end UserTest

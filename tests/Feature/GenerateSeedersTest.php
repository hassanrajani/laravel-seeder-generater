<?php

namespace Tests\Feature;

use Tests\TestCase;

class GenerateSeedersTest extends TestCase
{
    public function test_seeder_generation()
    {
        $this->artisan('generate:seeders')
            ->assertExitCode(0);
    }
}

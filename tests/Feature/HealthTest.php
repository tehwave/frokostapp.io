<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    /** @test */
    public function it_is_healthy()
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}

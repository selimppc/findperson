<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_persons_route_index(): void
    {
        $response = $this->get('/persons');
        $response->assertStatus(200);
    }

    public function test_persons_with_filter(): void
    {
        $rowLimit = 20;
        $birthYear = 1910;
        $birthMonth = 11;
        $response = $this->get('/persons?rowLimit='.$rowLimit.'&birthYear='.$birthYear.'&birthMonth='.$birthMonth);
        $response->assertStatus(200);
    }

}

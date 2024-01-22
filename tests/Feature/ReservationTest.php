<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Reservation;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function it_can_create_a_reservation()
    {
        $data = [
            'name' => 'John Doe',
            'reservation_time' => now()->addDay(),
            'walk_in' => false,
        ];

        $response = $this->postJson('/api/reservations', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['reservation']);
    }

    public function it_can_retrieve_all_reservations()
    {
        Reservation::factory()->count(3)->create();

        $response = $this->getJson('/api/reservations');

        $response->assertStatus(200)
            ->assertJsonStructure(['reservations']);
    }

}

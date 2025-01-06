<?php

use App\Models\Reservation;
use App\Models\Yacht;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a reservation for a yacht', function () {
    $yacht = Yacht::factory()->create();
    $data = [
        'yacht_id' => $yacht->id,
        'user_name' => 'John Doe',
        'reservation_date' => now()->addDay()->toDateString(),
        'duration_hours' => 4,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['user_name' => 'John Doe']);
    $this->assertDatabaseHas('reservations', $data);
});

it('cannot create a reservation with invalid data', function () {
    $data = [
        'yacht_id' => 999,
        'user_name' => '',
        'reservation_date' => now()->subDay()->toDateString(),
        'duration_hours' => 0,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['yacht_id', 'user_name', 'reservation_date', 'duration_hours']);
});

it('can filter reservations by status', function () {
    $yacht = Yacht::factory()->create();
    Reservation::factory()->for($yacht)->create();
    $reservation = Reservation::factory()->for($yacht)->create();

    $this->putJson("/api/reservations/{$reservation->id}/confirm");

    $response = $this->getJson('/api/reservations?status=confirmed');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data');
});

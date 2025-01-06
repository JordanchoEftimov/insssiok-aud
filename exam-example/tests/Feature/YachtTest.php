<?php

use App\Models\Reservation;
use App\Models\Review;
use App\Models\Yacht;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list all yachts with filtering and search', function () {
    Yacht::factory()->create(['name' => 'Luxury Yacht', 'type' => 'super yacht']);
    Yacht::factory()->create(['name' => 'Classic Beauty', 'type' => 'classic']);

    $response = $this->getJson('/api/yachts?search=Luxury&type=super yacht');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['name' => 'Luxury Yacht']);
});

it('can create a yacht with valid data', function () {
    $data = [
        'name' => 'Sunset Cruiser',
        'type' => 'classic',
        'capacity' => 10,
        'hourly_rate' => 500.0,
    ];

    $response = $this->postJson('/api/yachts', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['name' => 'Sunset Cruiser']);
    $this->assertDatabaseHas('yachts', $data);
});

it('cannot create a yacht with invalid data', function () {
    $data = [
        'name' => '',
        'type' => 'invalid_type',
        'capacity' => -5,
        'hourly_rate' => 0,
    ];

    $response = $this->postJson('/api/yachts', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'type', 'capacity', 'hourly_rate']);
});

it('can update a yacht with valid data', function () {
    $yacht = Yacht::factory()->create();

    $updateData = [
        'name' => 'Updated Yacht Name',
        'type' => 'super yacht',
        'capacity' => 15,
        'hourly_rate' => 600.0,
    ];

    $response = $this->putJson("/api/yachts/{$yacht->id}", $updateData);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Updated Yacht Name']);
    $this->assertDatabaseHas('yachts', $updateData);
});

it('can delete a yacht and cascade delete reservations and reviews', function () {
    $yacht = Yacht::factory()->create();
    $reservation = Reservation::factory()->for($yacht)->create();
    Review::factory()->for($reservation)->create();

    $response = $this->deleteJson("/api/yachts/{$yacht->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('yachts', ['id' => $yacht->id]);
    $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    $this->assertDatabaseMissing('reviews', ['reservation_id' => $reservation->id]);
});

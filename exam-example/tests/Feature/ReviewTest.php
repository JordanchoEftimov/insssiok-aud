<?php

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a review for a confirmed reservation', function () {
    $reservation = Reservation::factory()->create();

    $response = $this->putJson("/api/reservations/{$reservation->id}/confirm");

    $response->assertStatus(200);

    $data = [
        'reservation_id' => $reservation->id,
        'reviewer_name' => 'Jane Doe',
        'text' => 'Amazing experience!',
        'rating' => 5,
    ];

    $response = $this->postJson('/api/reviews', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['status' => 'pending']);
    $this->assertDatabaseHas('reviews', $data);
});

it('cannot create a review for an unconfirmed reservation', function () {
    $reservation = Reservation::factory()->create();
    $data = [
        'reservation_id' => $reservation->id,
        'reviewer_name' => 'Jane Doe',
        'rating' => 3,
    ];

    $response = $this->postJson('/api/reviews', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['reservation_id']);
});

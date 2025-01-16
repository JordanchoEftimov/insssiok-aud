<?php

use App\Enums\ReservationStatus;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

$total = 0;

afterAll(function () use (&$total) {
    echo "\n\nFinal Score: $total/100\n";
});

it('ensures the events table exists with necessary fields', function () use (&$total) {
    expect(Schema::hasTable('events'))->toBeTrue();

    $columns = [
        'id', 'name', 'slug', 'description', 'location',
        'event_date', 'capacity', 'created_at', 'updated_at',
    ];
    foreach ($columns as $column) {
        expect(Schema::hasColumn('events', $column))->toBeTrue();
    }

    $total += 3;
});

it('ensures the reservations table exists with necessary fields', function () use (&$total) {
    expect(Schema::hasTable('reservations'))->toBeTrue();

    $columns = [
        'id', 'event_id', 'user_name', 'ticket_quantity',
        'status', 'created_at', 'updated_at',
    ];
    foreach ($columns as $column) {
        expect(Schema::hasColumn('reservations', $column))->toBeTrue();
    }

    $total += 3;
});

it('fails to create an event with missing required fields', function () use (&$total) {
    $response = $this->postJson('/api/events', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'name', 'description', 'location', 'event_date', 'capacity',
        ]);

    $total += 5;
});

it('creates a new event with valid data', function () use (&$total) {
    $data = [
        'name' => 'Tech Meetup',
        'description' => 'A great tech meetup for developers.',
        'location' => 'San Francisco',
        'event_date' => now()->addDays(10)->toDateString(),
        'capacity' => 200,
    ];

    $response = $this->postJson('/api/events', $data);

    $response->assertStatus(201);

    $this->assertDatabaseHas('events', $data);

    $total += 5;
});

it('lists events with pagination and search by name or location', function () use (&$total) {
    Event::factory()->create([
        'name' => 'Music Festival',
        'location' => 'New York',
        'event_date' => now()->addDays(10),
        'capacity' => 500,
    ]);

    Event::factory()->create([
        'name' => 'Tech Conference',
        'location' => 'San Francisco',
        'event_date' => now()->addDays(15),
        'capacity' => 300,
    ]);

    Event::factory()->create([
        'name' => 'Art Expo',
        'location' => 'Los Angeles',
        'event_date' => now()->addDays(20),
        'capacity' => 200,
    ]);

    $response = $this->getJson('/api/events?search=Tech');

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) => $json->has('data', 1)
            ->has('data.0', fn ($json) => $json->where('name', 'Tech Conference')
                ->where('slug', 'tech-conference')
                ->where('location', 'San Francisco')
                ->where('capacity', 300)
                ->etc()
            )
            ->hasAll(['links', 'meta'])
        );

    $response = $this->getJson('/api/events?search=ngele');

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) => $json->has('data', 1)
            ->has('data.0', fn ($json) => $json->where('name', 'Art Expo')
                ->where('slug', 'art-expo')
                ->where('location', 'Los Angeles')
                ->where('capacity', 200)
                ->etc()
            )
            ->hasAll(['links', 'meta'])
        );

    $response = $this->getJson('/api/events');

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) => $json->has('data', 3)
            ->hasAll(['links', 'meta'])
        );

    $total += 5;
});

it('shows a single event with all required fields and reservations', function () use (&$total) {
    $event = Event::factory()->create([
        'name' => 'Tech Conference',
        'location' => 'San Francisco',
        'event_date' => now()->addDays(10),
        'capacity' => 300,
    ]);

    $reservations = Reservation::factory()->count(2)->create([
        'event_id' => $event->id,
        'user_name' => 'John Doe',
        'ticket_quantity' => 2,
    ]);

    $response = $this->getJson("/api/events/{$event->id}");

    $response->assertStatus(200);

    $response->assertJson([
        'data' => [
            'name' => 'Tech Conference',
            'location' => 'San Francisco',
            'capacity' => 300,
            'reservations' => $reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'user_name' => $reservation->user_name,
                    'ticket_quantity' => $reservation->ticket_quantity,
                ];
            })->toArray(),
        ],
    ]);

    $total += 5;
});

it('updates an existing event with valid data', function () use (&$total) {
    $event = Event::factory()->create([
        'name' => 'Original Event',
        'description' => 'Original description.',
        'location' => 'Original Location',
        'event_date' => now()->addDays(10),
        'capacity' => 100,
    ]);

    $updateData = [
        'name' => 'Updated Event',
        'description' => 'Updated description.',
        'location' => 'Updated Location',
        'event_date' => now()->addDays(15)->toDateString(),
        'capacity' => 150,
    ];

    $response = $this->putJson("/api/events/{$event->id}", $updateData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('events', $updateData);

    $total += 3;
});

it('fails to update an event with missing required fields', function () use (&$total) {
    $event = Event::factory()->create([
        'name' => 'Original Event',
        'description' => 'Original description.',
        'location' => 'Original Location',
        'event_date' => now()->addDays(10),
        'capacity' => 100,
    ]);

    $response = $this->putJson("/api/events/{$event->id}", []);

    $response->assertStatus(422);

    $total += 3;
});

it('fails to update an event with negative capacity', function () use (&$total) {
    $event = Event::factory()->create([
        'name' => 'Original Event',
        'description' => 'Original description.',
        'location' => 'Original Location',
        'event_date' => now()->addDays(10),
        'capacity' => 100,
    ]);

    $updateData = [
        'name' => 'Updated Event',
        'description' => 'Updated description.',
        'location' => 'Updated Location',
        'event_date' => now()->addDays(15)->toDateString(),
        'capacity' => -10,
    ];

    $response = $this->putJson("/api/events/{$event->id}", $updateData);

    $response->assertStatus(422);
    $this->assertDatabaseMissing('events', $updateData);

    $total += 2;
});

it('fails to update an event with date in the past', function () use (&$total) {
    $event = Event::factory()->create([
        'name' => 'Original Event',
        'description' => 'Original description.',
        'location' => 'Original Location',
        'event_date' => now()->addDays(10),
        'capacity' => 100,
    ]);

    $updateData = [
        'name' => 'Updated Event',
        'description' => 'Updated description.',
        'location' => 'Updated Location',
        'event_date' => now()->subDays(15)->toDateString(),
        'capacity' => 10,
    ];

    $response = $this->putJson("/api/events/{$event->id}", $updateData);

    $response->assertStatus(422);
    $this->assertDatabaseMissing('events', $updateData);

    $total += 2;
});

it('deletes an event with no confirmed reservations', function () use (&$total) {
    $event = Event::factory()->create();

    Reservation::factory()->create([
        'event_id' => $event->id,
        'status' => ReservationStatus::PENDING,
    ]);

    $response = $this->deleteJson("/api/events/{$event->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('events', ['id' => $event->id]);

    $total += 3;
});

it('fails to delete an event with confirmed reservations', function () use (&$total) {
    $event = Event::factory()->create();

    $reservation = Reservation::factory()->create([
        'event_id' => $event->id,
    ]);
    $this->putJson("/api/reservations/{$reservation->id}/confirm");

    $response = $this->deleteJson("/api/events/{$event->id}");

    $response->assertStatus(400);
    $this->assertDatabaseHas('events', ['id' => $event->id]);

    $total += 10;
});

it('allows a user to create a reservation if capacity is sufficient', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $data = [
        'event_id' => $event->id,
        'user_name' => 'John Doe',
        'ticket_quantity' => 5,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(201);
    $this->assertDatabaseHas('reservations', [
        'event_id' => $event->id,
        'user_name' => 'John Doe',
        'ticket_quantity' => 5,
        'status' => ReservationStatus::PENDING,
    ]);

    $total += 5;
});

it('fails to create a reservation if ticket quantity exceeds capacity', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $data = [
        'event_id' => $event->id,
        'user_name' => 'John Doe',
        'ticket_quantity' => 15,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(400);
    $this->assertDatabaseMissing('reservations', $data);

    $total += 8;
});

it('fails if event_id does not point to an existing event', function () use (&$total) {
    $data = [
        'event_id' => 9999,
        'user_name' => 'John Doe',
        'ticket_quantity' => 5,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['event_id']);

    $total += 2;
});

it('fails if ticket_quantity is not a positive integer', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $data = [
        'event_id' => $event->id,
        'user_name' => 'John Doe',
        'ticket_quantity' => -5,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['ticket_quantity']);

    $total += 2;
});

it('fails if user_name is missing', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $data = [
        'event_id' => $event->id,
        'ticket_quantity' => 5,
    ];

    $response = $this->postJson('/api/reservations', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['user_name']);

    $total += 2;
});

it('confirms a reservation if the status is pending', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $reservation = Reservation::factory()->create([
        'event_id' => $event->id,
        'status' => ReservationStatus::PENDING,
        'ticket_quantity' => 5,
    ]);

    $response = $this->putJson("/api/reservations/{$reservation->id}/confirm");

    $response->assertStatus(200);
    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => ReservationStatus::CONFIRMED,
    ]);
    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'capacity' => 5,
    ]);

    $total += 6;
});

it('fails to confirm a reservation if the status is not pending', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $reservation = Reservation::factory()->create([
        'event_id' => $event->id,
        'ticket_quantity' => 5,
    ]);

    $reservation->update([
        'status' => ReservationStatus::CANCELLED,
    ]);

    $response = $this->putJson("/api/reservations/{$reservation->id}/confirm");

    $response->assertStatus(400);
    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => ReservationStatus::CANCELLED,
    ]);

    $total += 6;
});

it('cancels a reservation if the status is confirmed', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 5]);

    $reservation = Reservation::factory()->create([
        'event_id' => $event->id,
        'ticket_quantity' => 5,
    ]);

    $reservation->update([
        'status' => ReservationStatus::CONFIRMED,
    ]);

    $response = $this->putJson("/api/reservations/{$reservation->id}/cancel");

    $response->assertStatus(200);
    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => ReservationStatus::CANCELLED,
    ]);
    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'capacity' => 10,
    ]);

    $total += 6;
});

it('fails to cancel a reservation if the status is not confirmed', function () use (&$total) {
    $event = Event::factory()->create(['capacity' => 10]);

    $reservation = Reservation::factory()->create([
        'event_id' => $event->id,
        'status' => ReservationStatus::PENDING,
        'ticket_quantity' => 5,
    ]);

    $response = $this->putJson("/api/reservations/{$reservation->id}/cancel");

    $response->assertStatus(400);
    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => ReservationStatus::PENDING,
    ]);

    $total += 6;
});

it('checks if ConfirmReservationAction class exists', function () use (&$total) {
    $this->assertTrue(class_exists(\App\Actions\ConfirmReservationAction::class));
    $total += 4;
});

it('checks if CancelReservationAction class exists', function () use (&$total) {
    $this->assertTrue(class_exists(\App\Actions\CancelReservationAction::class));
    $total += 4;
});

<?php

use App\Models\Jet;

it('returns a list of jets', function () {
    Jet::factory()->count(5)->create();

    $response = $this->getJson(route('jets.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'model',
                ],
            ],
            'links',
            'meta',
        ]);
});

it('returns a specific jet', function () {
    $jet = Jet::factory()->create();

    $response = $this->getJson(route('jets.show', $jet));

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $jet->id,
                'name' => $jet->name,
                'model' => $jet->model,
            ],
        ]);
});

it('creates a new jet', function () {
    $data = [
        'name' => 'New Jet',
        'model' => 'Model X',
        'capacity' => 150,
        'hourly_rate' => 3000,
    ];

    $response = $this->postJson(route('jets.store'), $data);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'New Jet',
                'model' => 'Model X',
                'capacity' => 150,
                'hourly_rate' => 3000,
            ],
        ]);
});

it('updates an existing jet', function () {
    $jet = Jet::factory()->create();

    $data = [
        'name' => 'Updated Jet',
        'model' => 'Updated Model',
        'capacity' => 200,
        'hourly_rate' => 3500,
    ];

    $response = $this->putJson(route('jets.update', $jet), $data);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Updated Jet',
                'model' => 'Updated Model',
                'capacity' => 200,
                'hourly_rate' => 3500,
            ],
        ]);
});

it('deletes a jet', function () {
    $jet = Jet::factory()->create();

    $response = $this->deleteJson(route('jets.destroy', $jet));

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'message' => 'Successfully deleted Jet',
            ],
        ]);

    $this->assertDatabaseMissing('jets', ['id' => $jet->id]);
});

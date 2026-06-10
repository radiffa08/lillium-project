<?php

use App\Models\User;

test('an admin can add a new codex entry', function () {
  
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
         ->post('/codex', [
             'title' => 'The Void Anomaly',
             'description' => 'A mysterious signal detected in sector 7.',
         ])
         ->assertStatus(302);

    $this->assertDatabaseHas('codex_entries', [
        'title' => 'The Void Anomaly',
    ]);
});

test('it requires a title when creating a codex entry', function () {

    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
         ->post('/codex', [
             'title' => '', 
             'description' => 'A mysterious signal detected in sector 7.',
         ])
         ->assertSessionHasErrors(['title']); 
});
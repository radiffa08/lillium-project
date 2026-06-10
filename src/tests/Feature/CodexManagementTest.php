<?php

use App\Models\User;

test('an admin can add a new codex entry', function () {
    // 1. Create an admin user
    $user = User::factory()->create(['role' => 'admin']);

    // 2. Act as that user and send a POST request to store a codex
    $this->actingAs($user)
         ->post('/codex', [
             'title' => 'The Void Anomaly',
             'description' => 'A mysterious signal detected in sector 7.',
         ])
         ->assertStatus(302); // 302 means it redirected after success

    // 3. Verify it exists in the database
    $this->assertDatabaseHas('codex_entries', [
        'title' => 'The Void Anomaly',
    ]);
});

test('it requires a title when creating a codex entry', function () {
    // 1. Create an admin user
    $user = User::factory()->create(['role' => 'admin']);

    // 2. Act as admin and try to submit a codex WITHOUT a title
    $this->actingAs($user)
         ->post('/codex', [
             'title' => '', // We left this blank on purpose!
             'description' => 'A mysterious signal detected in sector 7.',
         ])
         ->assertSessionHasErrors(['title']); 
         // This assertion checks that Laravel threw a validation error for 'title'
});
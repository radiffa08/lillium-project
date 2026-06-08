<?php

use Laravel\Dusk\Browser;

test('Test home page', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Lillium');
    });
});

test('Test codex', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/codex')
            ->assertSee('Codex of Anomalies');
    });
});

test('Test store', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/store')
            ->assertSee('Store');
    });
});

test('Test login page', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->assertSee('Welcome Traveller');
    });
});


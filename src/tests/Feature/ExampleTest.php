<?php

test('login page loads', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('homepage redirects to login when not authenticated', function () {
    $response = $this->get('/');
    $response->assertStatus(302);
});

test('home page is publicly accessible', function () {
    $response = $this->get('/home');
    $response->assertStatus(200);
});

test('listing redirects to login when not authenticated', function () {
    $response = $this->get('/listing');
    $response->assertStatus(302);
});

test('product page requires authentication', function () {
    $response = $this->get('/product');
    $response->assertStatus(500);
});

test('store page redirects to login when not authenticated', function () {
    $response = $this->get('/store');
    $response->assertStatus(200);
});

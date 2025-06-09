<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php
Route::get('/wilayah/provinces', function () {
    $client   = new \GuzzleHttp\Client();
    $response = $client->get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
    return json_decode($response->getBody(), true);
});

Route::get('/wilayah/regencies/{provinceId}', function ($provinceId) {
    $client   = new \GuzzleHttp\Client();
    $response = $client->get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
    return json_decode($response->getBody(), true);
});

Route::get('/wilayah/districts/{regencyId}', function ($regencyId) {
    $client   = new \GuzzleHttp\Client();
    $response = $client->get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$regencyId}.json");
    return json_decode($response->getBody(), true);
});

Route::get('/wilayah/villages/{districtId}', function ($districtId) {
    $client   = new \GuzzleHttp\Client();
    $response = $client->get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
    return json_decode($response->getBody(), true);
});

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/kingdom', 'KingdomController@createKingdom');

Route::post('/queen', 'KingdomController@createQueen');

Route::post('/queen/add', 'KingdomController@addQueen');

Route::post('/queen/place', 'KingdomController@placeQueen');

Route::post('/queen/move', 'KingdomController@moveQueen');

Route::post('/queen/rotate', 'KingdomController@rotateQueen');

Route::get('/output', 'KingdomController@output');
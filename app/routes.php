<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'FrontController@index');
Route::post('/updateplayer', 'FrontController@updateplayer');
Route::get('/gamestate', 'FrontController@gamestate');
Route::post('/set_game', 'FrontController@set_game');
Route::post('/addgame', 'FrontController@addgame');

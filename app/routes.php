<?php

Route::get('/', 'FrontController@index');
Route::get('/gamestate/{player_id}', 'FrontController@gamestate');
Route::post('/set_game', 'FrontController@set_game');
Route::post('/addgame', 'FrontController@addgame');
Route::delete('/destroygame', 'FrontController@destroy_game');

// Managing players
Route::post('/promote/{id}', 'PlayerController@promote');
Route::post('/createplayer', 'PlayerController@createplayer');
Route::post('/setplayerstate', 'PlayerController@setplayerstate');
Route::delete('/destroyplayer', 'PlayerController@destroy_player');

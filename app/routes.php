<?php

// Main interface
Route::get('/', 'FrontController@index');

// Managing games
Route::get('/gamestate/{player_id}', 'GameController@gamestate');
Route::post('/set_game', 'GameController@set_game');
Route::post('/addgame', 'GameController@addgame');
Route::delete('/destroygame', 'GameController@destroy_game');

// Managing players
Route::post('/promote/{id}', 'PlayerController@promote');
Route::post('/createplayer', 'PlayerController@createplayer');
Route::post('/setplayerstate', 'PlayerController@setplayerstate');
Route::delete('/destroyplayer', 'PlayerController@destroy_player');

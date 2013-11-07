<?php

Route::get('/', 'FrontController@index');
Route::post('/createplayer', 'FrontController@createplayer');
Route::post('/setplayerstate', 'FrontController@setplayerstate');
Route::get('/gamestate/{player_id}', 'FrontController@gamestate');
Route::post('/set_game', 'FrontController@set_game');
Route::post('/addgame', 'FrontController@addgame');
Route::post('/promote/{id}', 'FrontController@promote');
Route::delete('/destroygame', 'FrontController@destroy_game');
Route::delete('/destroyplayer', 'FrontController@destroy_player');

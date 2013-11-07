<?php

class FrontController extends BaseController
{
  public function index()
  {
    return View::make('index');
  }

  public function addgame()
  {
    Game::create(['name' => Input::json('name')]);
  }

  public function updateplayer()
  {
    // Create or update a new player
    $player = Player::find_or_create_by_name(Input::json('name'), Input::json('playing'));
    return $player->id;
  }

  public function gamestate($player_id)
  {
    return View::make('games', ['games' => Game::all(), 'player_id' => $player_id]);
  }

  public function set_game()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $game = Game::findOrFail(Input::json('game_id'));

    if (Input::json('playing') && !$player->games->contains($game->id)) {
      $player->games()->attach($game->id, ['created_at' => DB::raw('datetime()'), 'updated_at' => DB::raw('datetime()')]);
    }
    else {
      $player->games()->detach($game->id);
    }
  }
}

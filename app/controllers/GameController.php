<?php

class GameController extends BaseController
{
  public function addgame()
  {
    Game::create(['name' => Input::json('name')]);
  }

  public function destroy_game()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $game = Game::findOrFail(Input::json('game_id'));

    if (!$player->admin) {
      return Response::make('Not authorized', 403);
    }

    $game->delete();
  }

  public function gamestate($player_id)
  {
    // Log player contact
    $player = Player::findOrFail($player_id);
    $player->touch();

    // Purge offline players
    Player::purge_afk();

    // Return the gamestate
    return View::make('games', ['games' => Game::all(), 'player' => $player]);
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

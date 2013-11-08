<?php

class GameController extends BaseController
{
  /**
   * Add a new game to the system
   * @return void
   */
  public function addgame()
  {
    $player = Player::findOrFail(Input::json('admin_id'));
    if (!$player->admin) {
      return Response::make('Not authorized', 403);
    }

    Game::create(['name' => Input::json('name')]);
  }

  /**
   * Completely remove a game from the system
   * @return void
   */
  public function destroy_game()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $game = Game::findOrFail(Input::json('game_id'));

    if (!$player->admin) {
      return Response::make('Not authorized', 403);
    }

    $game->delete();
  }

  /**
   * Retrieve the updated state of all games
   * @param int $player_id
   * @return void
   */
  public function gamestate($player_id)
  {
    // Log player contact
    $player = Player::findOrFail($player_id);
    $player->touch();

    // Purge offline players
    Player::purge_afk();

    // Return the gamestate
    return View::make('games', ['games' => Game::orderBy('games.name')->get(), 'player' => $player]);
  }

  /**
   * Set or unset a player's interest in the game
   * @return void
   */ 
  public function set_game()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $game = Game::findOrFail(Input::json('game_id'));

    if (Input::json('playing') && !$player->games->contains($game->id)) {
      $player->games()->attach($game->id, ['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
    }
    else {
      $player->games()->detach($game->id);
    }
  }
}

<?php

class PlayerController extends BaseController
{
  /**
   * Promotes a player to admin
   * @param int $player_id
   * @return void
   */
  public function promote($player_id, $security_key)
  {
    $expected_key = getenv('ADMIN_KEY');

    if ($expected_key !== $security_key) {
      return Response::make('Not authorized', 403);
    }
    
    $player = Player::findOrFail($player_id);
    $player->admin = true;
    $player->save();
  }

  /**
   * Creates a new player; if the players name is already taken, use the existing player
   * @return void
   */
  public function createplayer()
  {
    // Create or update a new player
    $player = Player::find_or_create_by_name(Input::json('name'));
    return $player->id;
  }

  /**
   * Set the current state (playing or not) of a player
   * @return void
   */
  public function setplayerstate()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $player->playing = Input::json('playing');
    $player->save();
  }

  /**
   * Completely remove a player from the system
   * @return void
   */
  public function destroy_player()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $admin = Player::findOrFail(Input::json('admin_id'));

    if (!$admin->admin) {
      return Response::make('Not authorized', 403);
    }

    $player->delete();
  }
}

<?php

class PlayerController extends BaseController
{
  public function promote($player_id)
  {
    $player = Player::findOrFail($player_id);
    $player->admin = true;
    $player->save();
  }

  public function createplayer()
  {
    // Create or update a new player
    $player = Player::find_or_create_by_name(Input::json('name'));
    return $player->id;
  }

  public function setplayerstate()
  {
    $player = Player::findOrFail(Input::json('player_id'));
    $player->playing = Input::json('playing');
    $player->save();
  }

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

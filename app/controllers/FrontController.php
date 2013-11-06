<?php

class FrontController extends BaseController
{
  public function index()
  {
    return View::make('index');
  }

  public function updateplayer()
  {
    // Create or update a new player
    $player = Player::find_or_create_by_name(Input::json('name'), Input::json('playing'));
    return View::make('player', ['player' => $player]);
  }

  public function gamestate()
  {
    //FIXME implement method
  }
}

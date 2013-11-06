<?php

class Game extends Eloquent
{
  public function games()
  {
    return $this->belongsToMany('Player');
  }

  public function available_players_count()
  {
    return 1;
  }

  public function unavailable_players_count()
  {
    return 2;
  }
}
<?php

class Game extends Eloquent
{
  protected $fillable = ['name'];

  public function players()
  {
    return $this->belongsToMany('Player');
  }

  public function available_players()
  {
    return $this->players()->where('players.playing', '=', '0');
  }

  public function unavailable_players()
  {
    return $this->players()->where('players.playing', '=', '1');
  }
}

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

  public function delete()
  {
    // Clear game_player first
    DB::table('game_player')->where('game_id', '=', $this->id)->delete();

    return parent::delete();
  }
}

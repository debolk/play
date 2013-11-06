<?php

class Player extends Eloquent
{
  protected $fillable = ['name', 'playing'];

  public function games()
  {
    return $this->belongsToMany('Game');
  }

  public static function find_or_create_by_name($name, $playing)
  {
    $player = Player::where('name', '=', $name)->get();
    if ($player->count() > 0) {
      $player->playing = $playing;
      $player->last_poll = time();
    }
    else {
      $player = new Player(['name' => $name, 'playing' => $playing]);
      $player->save();
    }
    return $player;
  }
}

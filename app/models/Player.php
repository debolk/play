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
    $player = Player::where('name', '=', $name)->first();
    if ($player) {
      $player->playing = $playing;
    }
    else {
      $player = new Player(['name' => $name, 'playing' => $playing]);
    }
    $player->save();
    return $player;
  }

  public static function available()
  {
    return self::where('playing', '=', '0');
  }

  public static function unavailable()
  {
    return self::where('playing', '=', '1');
  }
}

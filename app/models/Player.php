<?php

class Player extends Eloquent
{
  protected $fillable = ['name', 'playing'];

  public function touch()
  {
    $this->updated_at = time();
    $this->save();
  }

  public static function purge_afk($timeout = 300)
  {
    // Purge player who are offline too long
    $players = Player::where('updated_at', '<', strftime('%F %H:%M', time() - $timeout))->get();

    foreach ($players as $player) {
      // Remove player
      $player->delete();
    }
  }

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

  public function delete()
  {
    // Clear game_player first
    DB::table('game_player')->where('player_id', '=', $this->id)->delete();

    return parent::delete();
  }
}

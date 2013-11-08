<?php

class Player extends Eloquent
{
  protected $fillable = ['name', 'playing'];

  /**
   * Set the updated_at column to now
   * @return bool
   */
  public function touch()
  {
    $this->updated_at = time();
    $this->save();
  }

  /**
   * Purge all AFK players from the system
   * @param int $timeout default 300 (5 minutes)
   * @return void
   */
  public static function purge_afk($timeout = 300)
  {
    // Purge player who are offline too long
    $players = Player::where('updated_at', '<', strftime('%F %H:%M', time() - $timeout))->get();

    foreach ($players as $player) {
      // Remove player
      $player->delete();
    }
  }

  /**
   * Relationship: a player has many games
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function games()
  {
    return $this->belongsToMany('Game');
  }

  /**
   * Finds an existing user based on a name, or creates a new one. Playing state is set to 0.
   * @param string $name
   * @return Player
   */
  public static function find_or_create_by_name($name)
  {
    $player = Player::where('name', '=', $name)->first();
    if (!$player) {
      $player = new Player(['name' => $name, 'playing' => 0]);
    }
    else {
      $player->playing = 0;
    }
    $player->save();
    return $player;
  }

  /**
   * Scope: all players that are currently not playing a game
   * @return Criteria
   */
  public static function available()
  {
    return self::where('playing', '=', '0');
  }

  /**
   * Scope: all players that are currently playing a game
   * @return Criteria
   */
  public static function unavailable()
  {
    return self::where('playing', '=', '1');
  }

  /**
   * Remove a player from the system
   * @see parent::delete()
   */
  public function delete()
  {
    // Clear game_player first
    DB::table('game_player')->where('player_id', '=', $this->id)->delete();

    return parent::delete();
  }
}

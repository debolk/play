<?php

class Game extends Eloquent
{
  /**
   * Writeable attributes through mass assignment
   */
  protected $fillable = ['name'];

  /**
   * Relationship: a game has many players
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function players()
  {
    return $this->belongsToMany('Player');
  }

  /**
   * Relationship: all players that want to play this game, and are currently available
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function available_players()
  {
    return $this->players()->where('players.playing', '=', '0');
  }

  /**
   * Relationship: all players that want to play this game, but are not available
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function unavailable_players()
  {
    return $this->players()->where('players.playing', '=', '1');
  }

  /**
   * Remove a game
   * @see parent::delete()
   */
  public function delete()
  {
    // Clear game_player first
    DB::table('game_player')->where('game_id', '=', $this->id)->delete();

    return parent::delete();
  }

  /**
   * Construct an URL to look up gameplay from this game on YouTube
   * @return string
   */
  public function youtube()
  {
    return 'http://www.youtube.com/results?'.http_build_query(['search_query' => $this->name.' gameplay']);
  }
}

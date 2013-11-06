<?php

class Game extends Eloquent
{
  public function games()
  {
    return $this->belongsToMany('Player');
  }
}
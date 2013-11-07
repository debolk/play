<?php foreach ($games as $game): ?>
  <div class="game row" data-id="<?php echo $game->id;?>">
    <div class="col-md-1">
      <?php if ($game->players->contains($player_id)): ?>
        <button class="btn btn-success toggle-game">
          <span class="glyphicon glyphicon-ok"></span>
          <span class="text">Yeah!</span>
        </button>
      <?php else: ?>
        <button class="btn btn-warning toggle-game">
          <span class="glyphicon glyphicon-remove"></span>
          <span class="text">Meh</span>
        </button>
      <?php endif; ?>
    </div>
    <div class="col-md-11">
      <h4>
        <span class="core"><?php echo $game->name; ?></span>
        <i class="glyphicon glyphicon-ok"></i> <?php $game->available_players()->count(); ?>
        <i class="glyphicon glyphicon-remove"></i> <?php $game->unavailable_players()->count(); ?>
      </h4>
      <p class="players">
        <?php foreach($game->available_players() as $player): ?>
          <span class="label label-success"><?php echo $player->game; ?></span>
        <?php endforeach; ?>
        <?php foreach($game->unavailable_players() as $player): ?>
          <span class="label label-warning"><?php echo $player->game; ?></span>
        <?php endforeach; ?>
      </p>
    </div>
  </div>
<?php endforeach; ?>
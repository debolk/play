<?php foreach ($games as $game): ?>
  <div class="game row" data-id="<?php echo $game->id;?>">
    <div class="col-md-1">
      <?php if ($game->players->contains($player_id)): ?>
        <button class="btn btn-info toggle-game">
          <span class="glyphicon glyphicon-ok"></span>
          <span class="text">Yeah!</span>
        </button>
      <?php else: ?>
        <button class="btn btn-meh toggle-game">
          <span class="glyphicon glyphicon-remove"></span>
          <span class="text">Meh</span>
        </button>
      <?php endif; ?>
    </div>
    <div class="col-md-11">
      <h4>
        <span class="core"><?php echo $game->name; ?></span>
        <span class="label label-success">
          <?php echo $game->available_players()->get()->count(); ?> players available
        </span>
        <span class="label label-warning">
          <?php echo $game->unavailable_players()->get()->count(); ?> players interested
        </span>
      </h4>
      <p class="players">
        <?php foreach($game->available_players()->get() as $player): ?>
          <span class="label label-success"><?php echo $player->name; ?></span>
        <?php endforeach; ?>
        <?php foreach($game->unavailable_players()->get() as $player): ?>
          <span class="label label-warning"><?php echo $player->name; ?></span>
        <?php endforeach; ?>
      </p>
    </div>
  </div>
<?php endforeach; ?>
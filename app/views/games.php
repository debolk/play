<?php if ($games->count() == 0): ?>
  <div class="alert alert-info">No games available</div>
<?php endif; ?>

<?php foreach ($games as $game): ?>
  <div class="game row" data-id="<?php echo $game->id;?>">
    <div class="col-md-1">
      <?php if ($game->players->contains($player->id)): ?>
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
        <span class="name">
          <?php echo $game->name; ?>
        </span>
        (<a target="_new" href="<?php echo $game->youtube(); ?>">what's this?</a>)
        <?php if ($player->admin): ?>
          <span class="destroy destroy-game glyphicon glyphicon-remove"></span>
        <?php endif; ?>
        <span class="label label-success">
          <?php echo $game->available_players()->get()->count(); ?> players available
        </span>
        <span class="label label-warning">
          <?php echo $game->unavailable_players()->get()->count(); ?> players interested
        </span>
      </h4>
      <p class="players">
        <?php foreach($game->available_players()->get() as $p): ?>
          <span class="label label-success player" data-id="<?php echo $p->id; ?>">
            <span class="name"><?php echo $p->name; ?></span>
            <?php if ($player->admin): ?>
              <span class="destroy destroy-player glyphicon glyphicon-remove"></span>
            <?php endif; ?>
          </span>
        <?php endforeach; ?>
        <?php foreach($game->unavailable_players()->get() as $p): ?>
          <span class="label label-warning player" data-id="<?php echo $p->id; ?>">
            <span class="name"><?php echo $p->name; ?></span>
            <?php if ($player->admin): ?>
              <span class="destroy destroy-player glyphicon glyphicon-remove"></span>
            <?php endif; ?>
          </span>
        <?php endforeach; ?>
      </p>
    </div>
  </div>
<?php endforeach; ?>
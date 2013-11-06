<div class="games">
  <?php foreach ($games as $game): ?>
    <div class="game row">
      <div class="span2">
        <input type="checkbox">        
      </div>
      <div class="span10">
        <h2><?php echo $game->name; ?></h2>
        <span class="available"><?php echo $game->available_players_count(); ?></span>
        <span class="available"><?php echo $game->unavailable_players_count(); ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</div>

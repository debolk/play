$(document).ready(function(){
  $('#player_data').submit(createplayer);

  $('#games').on('click', '.toggle-game', toggle_game);
  $('#games').on('click', '.destroy-game', destroy_game);
  $('#games').on('click', '.destroy-player', destroy_player);
  
  $('span', '.player-state').on('click', update_player_state);

  $('#add-game').submit(add_game);

  $('.request_admin_powers').on('click', request_admin_powers);
});

function request_admin_powers(event)
{
  event.preventDefault();

  var admin_key = prompt('Secret key?');
  $.ajax({
    url: '/promote/'+window.player_id+'/'+admin_key,
    method: 'POST',
    success: function() {
      add_notification('success', 'Promoted to admin');
      $('.admin').show();
    },
    error: function(){
      add_notification('danger', 'Could not promote to admin. You probably entered the wrong key.');
    },
  });
}

function update_player_state(event)
{
  event.preventDefault();

  // Get value
  var state = $(this).attr('data-value');

  // Send Ajax
  $.ajax({
    url: '/setplayerstate',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({player_id: window.player_id, playing: state}),
    error: function() {
      add_notification('danger', 'Could not set your playing state; please reload');
    },
    success: function() {
      // Update interface buttons
      if (state == 0) {
        $('span[data-value=0]').addClass('label-success').removeClass('label-meh');
        $('span[data-value=1]').addClass('label-meh').removeClass('label-warning');
      }
      else {
        $('span[data-value=0]').addClass('label-meh').removeClass('label-success');
        $('span[data-value=1]').addClass('label-warning').removeClass('label-meh');
      }
    }
  });
}

function destroy_game(event)
{
  event.preventDefault();
  var game = $($(this).parents('.game')[0]);
  var game_name = $.trim($($('.name',game)[0]).text());

  if (confirm('Are you sure you want to permanently destroy "'+game_name+'"?')) {
    $.ajax({
      url: '/destroygame',
      method: 'DELETE',
      contentType: 'json',
      data: JSON.stringify({
        player_id: window.player_id,
        game_id: game.attr('data-id'),
      }),
      success: function() {
        add_notification('success', 'Game removed');
      },
      error: function(){
        add_notification('danger', 'Could not destroy game');
      }
    });
  }
}

function destroy_player(event)
{
  event.preventDefault();
  var player = $($(this).parents('.player')[0]);

  if (confirm('Are you sure you want to purge "'+$.trim($('.name',player).text())+'"?')) {
    $.ajax({
      url: '/destroyplayer',
      method: 'DELETE',
      contentType: 'json',
      data: JSON.stringify({
        admin_id: window.player_id,
        player_id: player.attr('data-id'),
      }),
      success: function() {
        add_notification('success', 'Player purged');
      },
      error: function(){
        add_notification('danger', 'Could not purge player');
      }
    });
  }
}

function clear_notifications()
{
  $('#notifications').html('');
}

function add_notification(type, message)
{
  clear_notifications();
  $('<div>').addClass('alert alert-'+type).text(message).appendTo('#notifications');
}

function add_game(event)
{
  event.preventDefault();
  
  // Get input
  var name = $('input', this).val();

  // Send ajax
  $.ajax({
    url: '/addgame',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({name: name}),
    success: function(result){
      $('input[type="text"]', '#add-game').val('');
      add_notification('success', 'Game added');
    },
    error: function(){
      add_notification('danger', 'Something went wrong adding your game; please reload');
    },
  });
}

function toggle_game(event)
{
  event.preventDefault();
  var game_id = $($(this).parents('.game')[0]).attr('data-id');
  var playing = $(this).hasClass('btn-meh');

  // Send update to server
  $.ajax({
    url: '/set_game',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({
      player_id: window.player_id,
      game_id:  game_id,
      playing: playing,
    }),
    error: function(error) {
      add_notification('danger', 'Something went wrong adding your game preference; please reload');
    }
  });

  // Toggle interface button
  $(this).toggleClass('btn-meh btn-info');
  $('.glyphicon', this).toggleClass('glyphicon-remove glyphicon-ok');
  if (playing) {
    $('.text', this).text('Yeah!');
  }
  else {
    $('.text', this).text('Meh');
  }
}

function createplayer(event)
{
  event.preventDefault();
  $.ajax({
    url: '/createplayer',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({
      name: $('input[name="player_name"]').val(),
    }),
    success: function(player_id) {
      // Store our ID
      window.player_id = player_id;

      // Hide form
      $('#player_data').parent().slideUp();

      // Show player state form
      $('.player-state').slideDown();

      // Start querying for gamestate
      setTimeout(get_gamestate, 1000);
    },
    error: function(error) {
      add_notification('danger', 'Something went wrong adding your player details; please reload');
    },
  });
}

function get_gamestate()
{
  $.ajax({
    url: '/gamestate/'+window.player_id,
    contentType: 'json',
    success: function(result) {
      $('#games').html(result);
      setTimeout(get_gamestate, 1000);  
    },
    error: function(error) {
      add_notification('danger', 'Could not get gamestate; please reload');
    },
  });
}

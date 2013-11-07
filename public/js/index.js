$(document).ready(function(){
  $('#player_data').submit(update_player);

  $('#games').on('click', '.toggle-game', toggle_game);
  $('#games').on('click', '.destroy-game', destroy_game);
  $('#games').on('click', '.destroy-player', destroy_player);

  $('#add-game').submit(add_game);

  $( window ).konami({  
        cheat: function() {
            $.ajax({
              url: '/promote/'+window.player_id,
              method: 'POST',
              success: function() {
                display_success('Promoted to admin');
                $('.admin').show();
              },
              error: function(){
                display_error('Could not promote to admin. You probably need to sign in first');
              },
            });
        }
    });
});

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
        display_success('Game removed');
      },
      error: function(){
        display_error('Could not destroy game');
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
        display_success('Player purged');
      },
      error: function(){
        display_error('Could not purge player');
      }
    });
  }
}

function display_success(message)
{
  $('#notifications').html(''); // Clear existing notifications
  $('<div>').addClass('alert alert-success').text(message).appendTo('#notifications');
}
function display_error(message)
{
  $('#notifications').html(''); // Clear existing notifications
  $('<div>').addClass('alert alert-danger').text(message).appendTo('#notifications');
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
      $('input', '#add-game').val('');
      display_success('Game added');
    },
    error: function(){
      display_error('Something went wrong adding your game; please reload');
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
      display_error('Something went wrong adding your game preference; please reload');
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

function update_player(event)
{
  //FIXME reset player when first created?
  event.preventDefault();
  $.ajax({
    url: '/updateplayer',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({
      name: $('input[name="player_name"]').val(),
      playing: $('input[name="player_state"]:checked').val(),
    }),
    success: function(player_id) {
      // Store our ID
      window.player_id = player_id;

      // Start querying for gamestate
      setTimeout(get_gamestate, 1000);
    },
    error: function(error) {
      display_error('Something went wrong adding your player details; please reload');
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
      display_error('Could not get gamestate; please reload');
    },
  });
}

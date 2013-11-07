$(document).ready(function(){
  $('#player_data').submit(update_player);

  $('#games').on('click', '.toggle-game', toggle_game);

  $('#add-game').submit(add_game);

  $( window ).konami({  
        cheat: function() {
            display_success('Promoted to admin');
            $.ajax({
              url: '/promote/'+window.player_id,
              method: 'POST',
            });
            $('.admin').show();
        }
    });
});

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
      $('input', this).val('');
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

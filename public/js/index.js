$(document).ready(function(){
  $('#player_data').submit(update_player);
});

function update_player(event)
{
  event.preventDefault();
  $.ajax({
    url: '/updateplayer',
    method: 'POST',
    contentType: 'json',
    data: JSON.stringify({
      name: $('input[name="player_name"]').val(),
      playing: $('input[name="player_state"]').val(),
    }),
    success: function(result) {
      console.log(result);
    },
    error: function(error) {
      alert('Error occurred');
      window.location.reload();
    },
  });
}
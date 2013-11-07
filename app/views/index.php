<!DOCTYPE html>
<html>
  <head>
    <title>Play!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/index.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="page-header">
          <h1>Play! <small>with friends</small></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="notifications">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="" class="form-inline" id="player_data">
            <h2>Add your player:</h2>
            Name: <input type="text" class="input-large" name="player_name">
            Currently playing a game: 
              <input type="radio" name="player_state" value="1"> Yes
              <input type="radio" name="player_state" value="0"> No
            <input type="submit" value="Update">
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h1>Games available</h1>
        </div>
        <div class="col-md-12 admin">
          <form action="" id="add-game" class="form-inline">
            <input type="text" placeholder="Add a game">
            <input type="submit" value="Add game">
          </form>
        </div>
      </div>
      <div id="games">
      </div>
    </div>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/konami.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>

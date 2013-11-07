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
          <h2>Your name:</h2>
          <form action="" class="form-inline" id="player_data">
            <div class="form-group">
              <input type="text" class="form-control" name="player_name" placeholder="Real name">
            </div>
            <div class="form-group">
              <input class="btn btn-default" type="submit" value="Start gaming">
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 admin">
          <h2>Add a game</h2>
          <form action="" id="add-game" class="form-inline">
            <div class="form-group">
              <input type="text" placeholder="Add a game" class="form-control">
            </div>
            <div class="form-group">
              <input type="submit" value="Add game" class="btn btn-default">
            </div>
          </form>
        </div>
      </div>

      <p class="player-state">
        <strong>My status:</strong>
        <span class="label label-success" data-value="0">
          I'm available
        </span>
        <span class="label label-meh" data-value="1">
          I'm busy playing
        </span>
      </p>

      <div id="games">
      </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/konami.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>

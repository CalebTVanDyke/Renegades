<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Renegades</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="all" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	
	
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery.bracket.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.bracket.min.css" />

</head>
<body>

<div class="container">
	<div class="header">
			<h1>Game Renegades</h1>
	</div>
		<ul class="nav nav-tabs nav-justified">
			<li class=""><a id="home" href="index.php">Home</a></li>
			<li><a id="games" href="games.php">Games</a></li>
			<li class="active"><a id="tournaments" href="tournaments.php">Tournaments</a></li>
			<li><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
			<?php 
				if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<li><a id="profile" href="profile.php">Profile</a></li>';
				}
			?>
		</ul>
	<h2><?php echo $_POST["title"]; ?></h2>

 
	<div id="save"></div>
	<div id="dataOutput"></div>
	<div id="doubleElimination"></div>
	<script>
	
var saveData = {
    teams : [
      ["Team 1", "Team 2"], /* first matchup */
      ["Team 3", "Team 4"]  /* second matchup */
    ],
    results : [[1,0], [2,7]]
  }
  
var bigData = {
  teams : [
    ["Team 1",  "Team 2" ],
    ["Team 3",  "Team 4" ],
    ["Team 5",  "Team 6" ],
    ["Team 7",  "Team 8" ],
    ["Team 9",  "Team 10"],
    ["Team 11", "Team 12"],
    ["Team 13", "Team 14"],
    ["Team 15", "Team 16"]
  ],
  results : [[ /* WINNER BRACKET */
    [[3,5], [2,4], [6,3], [2,3], [1,5], [5,3], [7,2], [1,2]],
    [[1,2], [3,4], [5,6], [7,8]],
    [[9,1], [8,2]],
    [[1,3]]
  ], [         /* LOSER BRACKET */
    [[5,1], [1,2], [3,2], [6,9]],
    [[8,2], [1,2], [6,2], [1,3]],
    [[1,2], [3,1]],
    [[3,0], [1,9]],
    [[3,2]],
    [[4,2]]
  ], [         /* FINALS */
    [[3,8], [1,2]],
    [[2,1]]
  ]]
}


var doubleEliminationData = {
    teams : [
      ["Team 1", "Team 2"],
      ["Team 3", "Team 4"]
    ],
    results : [[      /* WINNER BRACKET */
      [[1,2], [3,4]], /* first and second matches of the first round */
      [[5,6]]         /* second round */
    ], [              /* LOSER BRACKET */
      [[7,8]],        /* first round */
      [[9,10]]        /* second round */
    ], [              /* FINALS */
      [[1,12], [13,14]],
      [[15,16]]       /* LB winner won first round so need a rematch */
    ]]
  }
 
 /* Double elimination */
$(function() {
    $('#doubleElimination').bracket({
      init: doubleEliminationData})
  })
 
/* Called whenever bracket is modified
 *
 * data:     changed bracket object in format given to init
 * userData: optional data given when bracket is created.
 */
function saveFn(data, userData) {
  var json = jQuery.toJSON(data)
  $('#saveOutput').text('POST '+userData+' '+json)
  /* You probably want to do something like this
  jQuery.ajax("rest/"+userData, {contentType: 'application/json',
                                dataType: 'json',
                                type: 'post',
                                data: json})
  */
}
 
$(function() {
    var container = $('#save')
    container.bracket({
      init: saveData,
      save: saveFn,
      userData: "http://myapi"})
 
    /* You can also inquiry the current data */
    var data = container.bracket('data')
    $('#dataOutput').text(jQuery.toJSON(data))
  })
  
/*Skips the consolation round to determine 3rd and 4th place*/
$(function() {
    $('div#noConsolationRound .demo').bracket({
      skipConsolationRound: true,
      init: doubleEliminationData})
  })
  </script>
</div>

<footer class="footer">
		<div class="container">
			<p class="text-muted">
				<?php 
					if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
						echo '<a href="logout.php"> Log out</a>';
					} else {
						echo '<a href="login.php">Log in</a> | <a href="register.php">Register</a>';
					}
				?>
			</p>
		</div>
</footer>
	
</body>
</html>

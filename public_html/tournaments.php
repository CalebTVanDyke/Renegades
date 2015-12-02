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
		<div id="content">
		</div>
		
		<form action="tournaments_display.php" method="post">
		Title of tournament:<br>
		<input type="text" name="title">
		<br>Consolation Round?<br>
		<input type="checkbox" name="answer" value="yes"> Yes <br>
		<input type="checkbox" name="answer" value="no"> No <br>
		<button id="consolButton">Change</button>
		<input type="submit" value="Create Bracket">
	</form>
	
	<div id="tournament"></div>
	
<script>	
var saveData = {
    teams : [
      ["Team 1", "Team 2"], /* first matchup */
      ["Team 3", "Team 4"]  /* second matchup */
    ],
    results : [[1,0], [2,7]]
}
 
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
  
  $('.consol').click(/*Skips the consolation round to determine 3rd and 4th place*/
	$(function() {
		$('div#noConsolationRound .demo').bracket({
		skipConsolationRound: true,
		init: doubleEliminationData})
	})
  });
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

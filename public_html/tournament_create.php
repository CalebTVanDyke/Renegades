<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Renegades</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="all" href="css/main.css">
	<link rel="stylesheet" type="text/css" media="all" href="css/sticky-footer.css">
	
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
			<li><a id="calenderPage" href="calenderPage.php">Calender</a></li>
			<?php 
				if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<li><a id="profile" href="profile.php">Profile</a></li>';
				}
			?>
		</ul>
		<div id="content">
		
		
		
		
		<form action="scripts/addTournament.php" method="get">
		Title of tournament: <br><input type="text" name="title"><br>
		<input type="radio" name="type" value="double" checked>Double Elimination<br>
		<input type="radio" name="type" value="single">Single Elimination<br>
		Max Entrants: <br><input type="number" name="entrants" max="64"><br>
		Price for Entry: <br><input type="integer" name="price"><br>
		Game: <br><input type="text" name="game"><br>
		Date: <br><input type="date" name="date"><br>
		<input type="submit" value="Create Bracket">
	</form>
	
	<!--Consolation option. Need javascript integration in order for it to work
	<br><br>
	<button onclick="checkConsolation()">Consolation Round?</button>
	<label><input id="consolation" type="checkbox">Yes</label>-->
	
	</div>
	
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


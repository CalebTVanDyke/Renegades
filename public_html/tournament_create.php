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
		<!--Tabs to other pages-->
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
		
		
		<!--We include our database connection file here and create a
			connection instance-->
		<?php
			include_once ('../resources/sqlconnect.php');
			$sql = SqlConnect::getInstance();	
			$query = "SELECT name, game_id FROM Game";
			$result = $sql->runQuery($query);			
		?>
			
		<!-- A form that gathers all the information for the tournament then submits the info to our
			addTournament php script.-->
		<form action="scripts/addTournament.php" method="get">
		Title of tournament: <br><input type="text" name="title"><br><br>
		<input type="radio" name="type" value="double" checked>Double Elimination<br><br>
		<input type="radio" name="type" value="single">Single Elimination<br><br>
		Max Entrants: <br><input type="number" name="entrants" max="64"><br><br>
		Price for Entry: <br><input type="integer" name="price"><br><br>
		Select Game:
		<select name="game_id">
			<?php
				while($row = $result->fetch_assoc())
					echo '<option value="'.$row["game_id"].'">'.$row["name"].'</option>';
			?>
		</select><br><br>
		Date: <br><input type="date" name="date"><br><br>
		<input type="submit" value="Create Bracket">
	</form>
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


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
		<?php 
				//Displays option to make a new tournament if admin account is viewing
				if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
					echo '<form action="tournament_create.php" method="post">
					<input type="submit" value="Create New Tournament">
						</form>';
				}
		?>	

	<!-- List of tournaments-->
	<ul id="tournaments">
		<?php
				include_once ('../resources/sqlconnect.php');
				$sql = SqlConnect::getInstance();
				$result = $sql->runQuery("SELECT name, date, open, tournament_id FROM Tournament;");
				
				//Displays links to tournaments. Links either to display page for tournament if sign ups are closed.
				//Or links to create bracket tournament if sign ups have not been completed.
				while ($row = $result->fetch_assoc()) {
					if($row["open"]==0)
						echo '<li><a href="tournaments_display.php?tournament_id='.$row["tournament_id"].'">'.$row["name"].' '.$row["date"].'</li>';
					else
						echo '<li><a href="tournament_create_bracket.php?tournament_id='.$row["tournament_id"].'&title='.$row["name"].'">'.$row["name"].' '.$row["date"].'</li>';
				}
			?>
	</ul>
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


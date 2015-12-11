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
	<link rel="stylesheet" type="text/css" media="all" href="css/calender.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="header">
				<h1>Game Renegades</h1>
		</div>
		<ul class="nav nav-tabs nav-justified">
				<li><a id="home" href="index.php">Home</a></li>
				<li><a id="games" href="games.php">Games</a></li>
				<li><a id="tournaments" href="tournaments.php">Tournaments</a></li>
				<li><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
				<li class="active"><a id="calenderPage" href="calenderPage.php">Calender</a></li>
				<?php
					if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
						echo '<li><a id="profile" href="profile.php">Profile</a></li>';
					}
				?>
			</ul>
		<div id="content">
			<iframe src="https://calendar.google.com/calendar/embed?title=Renegades%20Calendar&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=osfem006pqe8cvpv5943k305mo%40group.calendar.google.com&amp;color=%2342104A&amp;src=7vtpocurk1s51ovj98150dv7as%40group.calendar.google.com&amp;color=%232F6309&amp;src=1so33q7i4jfvnmo8p67egef71k%40group.calendar.google.com&amp;color=%238C500B&amp;ctz=America%2FChicago" style="border-width:0" width="600" height="600" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
</body>

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
</html>

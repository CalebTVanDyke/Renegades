<?php 
session_start();
if (!isset($_SESSION["player_tag"]) && !isset($_SESSION["id"])) {
	header("Location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Renegades</title>
<link rel="stylesheet" type="text/css" media="all"
	href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="all"
	href="css/main.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Game Renegades</h1>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a id="home">Home</a></li>
			<li><a id="games">Games</a></li>
			<li><a id="tournaments">Tournaments</a></li>
			<li><a id="leaderboards">Leaderboards</a></li>
			<li><a id="profile">Profile</a></li>
		</ul>
		<div id="content">
			<?php
				include_once ('../resources/sqlconnect.php');

				$sql = SqlConnect::getInstance();
				$result = $sql->runQuery("SHOW TABLES;");
				while ($row = $result->fetch_assoc()) {
					print $row["Tables_in_db461rene"] . "<br>";
				}
				echo $_SESSION["player_tag"];
			?>
		</div>
		<a href="logout.php"><button type="button" class="btn btn-default">Logout</button></a>
	</div>
</body>
</html>

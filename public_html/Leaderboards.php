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
</head>
<body>

<div class="container">
	<div class="header">
			<h1>Game Renegades</h1>
	</div>
	<ul class="nav nav-tabs nav-justified">
		<li><a id="home">Home</a></li>
		<li><a id="games">Games</a></li>
		<li><a id="tournaments">Tournaments</a></li>
		<li class="active"><a id="leaderboards">Leaderboards</a></li>
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
		?>

		<h2>Leaderboard -- <select><option value="volvo">Volvo</option></select></h2>
		<p></p>
		<div class="searchable">
			<button type="button">Sort By Last Name</button>
			<button type="button">Sort By First Name</button>
			<button type="button">Sort By Score</button>
			<input type="text" name="Name">
			<img src="" alt="Search" style="width:304px;height:228px;">
		</div>

		<table class="table table-hover">
			<thead>
				<tr>
					<th>Player Name</th>
					<th></th>
					<th>Player Score</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>John</td>
					<td></td>
					<td>john@example.com</td>
				</tr>
				<tr>
					<td>Mary</td>
					<td></td>
					<td>mary@example.com</td>
				</tr>
				<tr>
					<td>July</td>
					<td></td>
					<td>july@example.com</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</body>
</html>

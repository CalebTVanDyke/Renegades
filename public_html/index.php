<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Renegades</title>
<link rel="stylesheet" type="text/css" media="all"
	href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="all"
	href="css/main.css">
<link rel="stylesheet" type="text/css" media="all"
	href="css/sticky-footer.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.carousel').carousel();
});
</script>

</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Game Renegades</h1>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a id="home" href="index.php">Home</a></li>
			<li><a id="games" href="games.php">Games</a></li>
			<li><a id="tournaments" href="tournaments.php">Tournaments</a></li>
			<li><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
			<li><a id="calenderPage" href="calenderPage.php">Calender</a></li><li>
			<?php
				if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<li><a id="profile" href="profile.php">Profile</a></li>';
				}
			?>
		</ul>
		<div id="content">
			<?php
				include_once ('../resources/sqlconnect.php');

				$sql = SqlConnect::getInstance();
				$result = $sql->runQuery("SELECT name, description, image_name FROM Game where featured=1;");
				$count = 0;
				$data = array();
				while ($row = $result->fetch_assoc()) {
					array_push($data, array("name" => $row["name"], "description" => $row["description"], "image_name" => $row["image_name"]));
					$count++;
				}
			?>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php
						for ($i = 0; $i < $count; $i++) {
							if ($i == 0) {
								echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'" class="active"></li>';
							} else {
								echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li>';
							}
						}
					?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<?php
						$i = 0;
						foreach ($data as $item) {
							if ($i == 0) {
								echo '<div class="item active">';
							} else {
								echo '<div class="item">';
							}
							echo '<img src="../resources/game_images/'.$item["image_name"].'" alt="">';
							echo '<div class="carousel-caption">';
							echo '<a href="games.php?game=' . $item["name"] . '""><h3 class="border-text">' . $item["name"] . '</h3></a>';
							echo '</div>';
							echo '</div>';
							$i++;
						}
					?>
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
				 <div class="main-text hidden-xs">
				 	<div class="text-center">
				 	</div>
				 </div>
			</div>
		</div>
		<p>
			<br>
			<h4>Welcome to Game Renegades</h4>
			<hr>
			Where everyone across Iowa State can get together and enjoy playing video games. We'll all get together at times and throw LAN parties once in awhile where we can all play the same game against each other and of course have fun! LAN is both console and PC gaming. We are also trying to play against other colleges and universities around the US.
		</p>
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

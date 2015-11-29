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
	$('.carousel').carousel({
	});
});
</script>

</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Game Renegades</h1>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li><a id="home" href="index.php">Home</a></li>
			<li class="active"><a id="games" href="games.php">Games</a></li>
			<li><a id="tournaments">Tournaments</a></li>
			<li><a id="leaderboards">Leaderboards</a></li>
			<?php 
				if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<li><a id="profile">Profile</a></li>';
				}
			?>
		</ul>
		<div id="content">
			<?php
				include_once ('../resources/sqlconnect.php');

				$sql = SqlConnect::getInstance();
				$result = $sql->runQuery("SELECT name FROM Game where featured=1;");
				$data = array();
				$count = 0;
				while ($row = $result->fetch_assoc()) {
					$count++;
					array_push($data, array("name" => $row["name"]));
				}
				$selected = NULL;
				if (isset($_GET["game"])) {
					$selected = $_GET["game"];
				}
			?>
			<div class="row">
				<div class="col-md-4">
					<ul class="nav nav-pills">
						<?php 
							for ($i = 0; $i < $count; $i++) {
								if (($i == 0 && $selected == NULL) || $data[$i]['name'] == $selected) {
									echo '<li role="presentation" class="active"><a href="games.php?game=' . $data[$i]['name'] . '">' . $data[$i]['name'] . '</a></li>';
									$selected = $data[$i]['name'];
								} else {
									echo '<li role="presentation"><a href="games.php?game=' . $data[$i]['name'] . '">' . $data[$i]['name'] . '</a></li>';
								}
							}
						?>
					</ul>
				</div>
				<div class="col-md-8">
					<?php
						echo '<h3>' . $selected . '</h3>';
						echo '<img class="img-responsive" src="../resources/game_images/'.$selected.'.jpg" alt="">';
						$result = $sql->runQuery("SELECT description FROM Game where name='" . $selected . "'");
						while ($row = $result->fetch_assoc()) {
							echo '<br><p>' . $row['description'] . '</p>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted">
				<?php 
					if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
						echo '<a href="logout.php"> Log out</a>';
					} else {
						echo '<a href="login.php">Log in</a>';
					}
				?>
			</p>
		</div>
	</footer>
</body>
</html>

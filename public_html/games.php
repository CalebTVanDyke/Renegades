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
	$('.feature-game').change(function(event){
		var val = $(this).val();
		var checked = this.checked ? 1 : 0;
		$.ajax({
			url: 'scripts/setFeatured.php',
			data: {'id' : val, 'setTo' : checked}
		}).done(function(response) {
		})
	})
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
			<li><a id="tournaments" href="tournaments.php">Tournaments</a></li>
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
				include_once ('../resources/sqlconnect.php');
				// get game info for the selected game or load the first game
				$selected = NULL;
				if (isset($_GET["game"])) {
					$selected = $_GET["game"];
				}
				$sql = SqlConnect::getInstance();
				$result = $sql->runQuery("SELECT name, featured, game_id, image_name FROM Game;");
				$data = array();
				$count = 0;
				$featured = false;
				$id = -1;
				$image_name = NULL;
				while ($row = $result->fetch_assoc()) {
					if ($selected == NULL && $count == 0) {
						$id = $row["game_id"];
						$featured = $row["featured"];
						$image_name = $row["image_name"];
					}
					$count++;
					array_push($data, array("name" => $row["name"]));
					if ($selected != NULL && $row["name"] == $selected) {
						$id = $row["game_id"];
						$featured = $row["featured"];
						$image_name = $row["image_name"];
					}
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
						if (isset($_GET['error'])) {
							echo '<div class="alert alert-danger" role="alert" id="alert">' . $_GET["error"] . '</div>';
						}
						// Display admin panel if user is admin
						if (isset($_SESSION['admin']) && $_SESSION['admin']) {
							echo '<div id="admin-panel">';
							echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addGame">Add Game</button> ';
							echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editGame">Edit Game</button> ';
							echo '<a href="scripts/deleteGame.php?toDelete='.$id.'"><button type="button" class="btn btn-danger" data-toggle="modal">Delete Game</button></a> ';
							echo '<label>';
							if ($featured) {
								echo '<input checked type="checkbox" value="' . $id . '" class="feature-game">';
							} else {
								echo '<input type="checkbox" value="' . $id . '" class="feature-game">';
							}
							echo ' Featured Game';
							echo '</label>';
							echo '</div>';
						}
					?>
					<?php
						// Display selected game
						echo '<h3>' . $selected . '</h3>';
						echo '<img class="img-responsive" src="../resources/game_images/'.$image_name.'" alt="">';
						$result = $sql->runQuery("SELECT description, genre, release_date, max_players FROM Game where name='" . $selected . "'");
						while ($row = $result->fetch_assoc()) {
							echo '<h4>Description</h4>';
							$description = $row['description'];
							echo '<p>' . $description . '</p>';
							echo '<h4>Genre</h4>';
							$genre = $row['genre'];
							echo '<p>' . $genre . '</p>';
							echo '<h4>Release Date</h4>';
							$date = $row['release_date'];
							echo '<p>' . $date . '</p>';
							echo '<h4>Max Players</h4>';
							$max_players = $row['max_players'];
							echo '<p>' . $max_players . '</p>';
						}
					?>
					<?php
						if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
							echo '<h4>Other users</h4>';
							echo '<ul>';
							$result = $sql->runQuery("SELECT mg.member_id, m.player_tag FROM MemberGame mg, Member m WHERE game_id=" . $id . " AND mg.member_id != " . $_SESSION["id"] . " AND mg.member_id=m.member_id;");
							while ($row = $result->fetch_assoc()) {
								echo '<li><a href="profile.php?user=' . $row['member_id'] . '">' . $row["player_tag"] . '</a>';
							}
							echo '</ul>';
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
						echo '<a href="login.php">Log in</a> | <a href="register.php">Register</a>';
					}
				?>
			</p>
		</div>
	</footer>
	<!-- Modal -->
	<div class="modal fade" id="addGame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Game</h4>
			  </div>
			  <div class="modal-body">
					<form id="addGameForm" action="scripts/addGame.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>Game Title <input name="title" type="text" class="form-control"></label>
						</div>
						<div class="form-group">
							<label>Release Date <input name="releaseDate" type="date" class="form-control"></label>
						</div>
						<div class="form-group">
							<label>Genre <input name="genre" type="text" class="form-control"></label>
						</div>
						<div class="max-players">
							<label>Max Players <input name="maxPlayers" type="number" class="form-control"></label>
						</div>
						<div class="form-group">
							<label>Description<textarea name="description" class="form-control"></textarea></label>
						</div>
						<div class="form-group">
							<label>Image<input name="image" type="file" class="form-control"></label>
						</div>
					</form>
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" form="addGameForm" class="btn btn-primary">Save changes</button>
			  </div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="editGame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Game</h4>
			  </div>
			  <div class="modal-body">
					<form id="editGameForm" action="scripts/editGame.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>Game Title <input name="title" type="text" class="form-control" value="<?php echo $selected; ?>"></label>
						</div>
						<div class="form-group">
							<label>Release Date <input name="releaseDate" type="date" class="form-control" value="<?php echo $date; ?>"></label>
						</div>
						<div class="form-group">
							<label>Genre <input name="genre" type="text" class="form-control" value="<?php echo $genre; ?>"></label>
						</div>
						<div class="max-players">
							<label>Max Players <input name="maxPlayers" type="number" class="form-control" value="<?php echo $max_players ;?>"></label>
						</div>
						<div class="form-group">
							<label>Description<textarea name="description" class="form-control"><?php echo $description; ?></textarea></label>
						</div>
						<div class="form-group">
							<label>New Image<input name="image" type="file" class="form-control"></label>
						</div>
					</form>
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" form="editGameForm" class="btn btn-primary" name="id" value="<?php echo $id; ?>">Save changes</button>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>

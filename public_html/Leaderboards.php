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
	<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
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
		
		<?php
			include_once ('../resources/sqlconnect.php');

			$sql = SqlConnect::getInstance();
			$result3 = $sql->runQuery("SELECT g.name, p.name FROM db461rene.Game g, db461rene.Platform p, db461rene.GamePlatform gp WHERE g.game_id=gp.game_id AND gp.platform_id=p.platform_id;");
        ?>

		<h2>Leaderboard -- <select name="Games">
			<?php
				while ($row3 = $result3->fetch_assoc()) {
					$selectedG = $row3["g.name"];
					$selectedP = $row3["p.name"];
					echo '<option value="'.$selectedG.'">'.$selectedG.'/'.$selectedP.'</option>';
				}
			?>
		</select></h2>
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
            <?php
			$selected_val = $_POST['Games'];
			$result1 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses FROM db461rene.Game g, db461rene.Platform p, db461rene.Member m, db461rene.MemberGame mg, db461rene.GamePlatform gp WHERE g.game_id=gp.game_id AND gp.platform_id=p.platform_id AND m.member_id=mg.member_id AND mg.game_id=g.game_id AND g.name=".$selected_val.";");
			
               while ($row1 = $result1->fetch_assoc()) {
				   $score = $row1["mg.wins"]'/('$row1["mg.losses"]'+'$row1["mg.losses"]')';
				   echo "<tr>";
                   echo "<td>".$row1["m.player_tag"]."</td>";
                   echo "<td>".$score."</td>";
                   echo "</tr>";
				}
            ?>
			</tbody>
        </table>
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
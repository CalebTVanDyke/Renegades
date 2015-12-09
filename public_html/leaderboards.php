<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
			<li><a id="home" href="index.php">Home</a></li>
			<li><a id="games" href="games.php">Games</a></li>
			<li><a id="tournaments" href="tournaments.php">Tournaments</a></li>
			<li class="active"><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
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
		<?php
			$sql = SqlConnect::getInstance();
			$result = $sql->runQuery("SELECT g.name FROM db461rene.Game g");
			
			$count = 0;
			$gData = array();
			
			while ($row = $result->fetch_row()) {
				array_push($gData, array("g.name" => $row[0]));
				$count++;
			}
		?>

		<h2>Select Leaderboard -- <span style="font-size:50%;"><form action="#" method="get">
		<select name="Games">
			<?php				
				for ($i = 0; $i < $count; $i++) {
					echo ('<option value="' . ($gData[$i]['g.name']) . '">' . ($gData[$i]['g.name']) . '</option>');
				}
			?>
		</select>
		<input type="submit" name="submit" value="get"/>
		</form></span></h2>
		<?php
			if(isset($_GET['submit'])){
				$selected_val = $_GET['Games'];  // Storing Selected Value In Variable
				$num = $i;
			}else{
				$selected_val = $gData[0]['g.name'];
			}
		?>
		
		<br/><br/>
		
		<span class="searchingTitle">
			<?php
			echo ('<h3>'.$selected_val.' Leaderboards</h3>');
			?>
			<form action="leaderboards.php" method="post">
					<input type="text" name="Name">
					<!--<img src="../resources/game_images/Magnify Glass.jpg" alt="Submit" style="width:40px;height:30px;"/>-->
					<input type="submit" value="Search">
					</input>
			</form>
		</span>
			
		<p></p>
		<div class="searchable">
			
		<br/><br/>
		
        <table class="table table-hover">
			<thead>
				<tr>
				<?php
					echo ('<th><a href="leaderboards.php?sort=player&game='.$selected_val.'">Player Tag</a></th>
					<th><a href="leaderboards.php?sort=wins&game='.$selected_val.'">Wins</a></th>
					<th><a href="leaderboards.php?sort=losses&game='.$selected_val.'">Losses<a/></th>
					<th>Platform</th>')
				?>
				</tr>
			</thead>
			<tbody>
            <?php
			
				if (isset($_GET['game'])){
					$selected_val = $_GET['game'];
				}
				
				if ($_GET['sort'] == 'player')
				{
					$result2 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses, p.name FROM db461rene.Game g, db461rene.Member m, db461rene.MemberGame mg, db461rene.Platform p, db461rene.GamePlatform gp WHERE (g.name='".$selected_val."') AND (m.member_id=mg.member_id) AND (g.game_id=mg.game_id) AND (g.game_id=gp.game_id) AND (gp.platform_id=p.platform_id) ORDER BY m.player_tag;");
				}
				elseif ($_GET['sort'] == 'wins')
				{
					$result2 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses, p.name FROM db461rene.Game g, db461rene.Member m, db461rene.MemberGame mg, db461rene.Platform p, db461rene.GamePlatform gp WHERE (g.name='".$selected_val."') AND (m.member_id=mg.member_id) AND (g.game_id=mg.game_id) AND (g.game_id=gp.game_id) AND (gp.platform_id=p.platform_id) ORDER BY mg.wins;");
				}
				elseif ($_GET['sort'] == 'losses')
				{
					$result2 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses, p.name FROM db461rene.Game g, db461rene.Member m, db461rene.MemberGame mg, db461rene.Platform p, db461rene.GamePlatform gp WHERE (g.name='".$selected_val."') AND (m.member_id=mg.member_id) AND (g.game_id=mg.game_id) AND (g.game_id=gp.game_id) AND (gp.platform_id=p.platform_id) ORDER BY mg.losses;");
				}elseif (isset($_POST['submit']))
				{
					$search = $_POST['Name'];
					
					$result2 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses, p.name FROM db461rene.Game g, db461rene.Member m, db461rene.MemberGame mg, db461rene.Platform p, db461rene.GamePlatform gp WHERE (g.name='".$selected_val."') AND (m.member_id=mg.member_id) AND (g.game_id=mg.game_id) AND (g.game_id=gp.game_id) AND (gp.platform_id=p.platform_id) AND (m.player_tag='".$search."') ORDER BY m.player_tag;");
				}else{
					$result2 = $sql->runQuery("SELECT m.player_tag, mg.wins, mg.losses, p.name FROM db461rene.Game g, db461rene.Member m, db461rene.MemberGame mg, db461rene.Platform p, db461rene.GamePlatform gp WHERE (g.name='".$selected_val."') AND (m.member_id=mg.member_id) AND (g.game_id=mg.game_id) AND (g.game_id=gp.game_id) AND (gp.platform_id=p.platform_id) ORDER BY p.name ASC;");
				}
			
				$count2 = 0;
				$wData = array();
				$lData = array();
				$tData = array();
				$pData = array();
				
				while ($row = $result2->fetch_row()) {
					array_push($tData, array("m.player_tag" => $row[0]));
					array_push($wData, array("mg.wins" => $row[1]));
					array_push($lData, array("mg.losses" => $row[2]));
					array_push($pData, array("p.name" => $row[3]));
					$count2++;
				}
				
				for ($i = 0; $i < $count2; $i++) {
					if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
						
						$result3 = $sql->runQuery("SELECT m.member_id FROM db461rene.Member m WHERE m.player_tag = '" .($tData[$i]["m.player_tag"]). "';");
						//var_dump($tData[$i]["m.player_tag"]);
						//var_dump($result3);
						$mData = array();
						while ($row2 = $result3->fetch_row()) {
							array_push($mData, array("m.member_id" => $row2));
						}
						//var_dump($row2);
						var_dump($mData);
						if ($_SESSION["player_tag"] == $tData[$i]["m.player_tag"]){
							echo ('<tr bgcolor="#FFCC99"><td><a href="profile.php?user=' .$mData[$i]['m.member_id']. '">' .($tData[$i]["m.player_tag"]). '</a></td><td>' .($wData[$i]["mg.wins"]). '</td><td>' .($lData[$i]["mg.losses"]). '</td><td>' .($pData[$i]["p.name"]). '</td></tr>');
						}else{
							echo ('<tr><td><a href="profile.php?user=' .$mData[$i]['m.member_id']. '">' .($tData[$i]["m.player_tag"]). '</a></td><td>' .($wData[$i]["mg.wins"]). '</td><td>' .($lData[$i]["mg.losses"]). '</td><td>' .($pData[$i]["p.name"]). '</td></tr>');
						}
					}else{
						echo ('<tr><td>' .($tData[$i]["m.player_tag"]). '</td><td>' .($wData[$i]["mg.wins"]). '</td><td>' .($lData[$i]["mg.losses"]). '</td><td>' .($pData[$i]["p.name"]). '</td></tr>');
					}
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
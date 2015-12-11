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
<script type="text/javascript">
//Saves the current status of the bracket into the database
//whenever the Save Bracket button is pushed.
$(document).ready(function() {
	$('.finish-bracket').click(function(event){
		var val = $('.tournament_id').val();
		$.ajax({
			url: 'scripts/saveTournament.php',
			data: {'bracket': JSON.stringify(saveData), 'tournament_id' : val}
		}).done(function(response) {
			console.log(response);
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
			include_once ('../resources/sqlconnect.php');
			$tournament_id = $_GET["tournament_id"];
			$current_member_id = $_SESSION["id"];
			$joined = false;
			$name = "Tournament";
			$bracket;
			$game_id = -1;
			$game = "Game";
			$count = 0;
			$sql = SqlConnect::getInstance();
				
			//Get Tournament Info
			$query = "SELECT entries, name, game_id, bracket FROM Tournament WHERE tournament_id='$tournament_id'";
			$result = $sql->runQuery($query);

			while ($row = $result->fetch_assoc()) {
				$max_entries = $row["entries"];
				$name = $row["name"];
				$game_id = $row["game_id"];
				$bracket = $row["bracket"];
			}
			
			//Get Game name
			$query = "SELECT  name FROM Game WHERE game_id='$game_id'";
			$result = $sql->runQuery($query);

			while ($row = $result->fetch_assoc()) {
				$game = $row["name"];
			}
		?>
		
		<!--Name of the tournament and the game the tournament is for-->
		<h2><?php echo $name; ?></h2>
		<h3><?php echo $game; ?></h3>
		
		<!--Displays tournament with different options depending on admin or not-->
			<?php 
				if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
					echo '<div id="tournament"></div>';
				}
				else
					echo '<div id="tournamentUsers"></div>';
			?>	
		
		<!--List of Entries and handling and finalize button-->
		<label>List of Participates</label>
		<ol id="entrants">
			<?php
				//Run either insert or delete queries on value of action
				if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'Join':
						$sql->runQuery("INSERT INTO MemberTournament VALUES('$current_member_id','$tournament_id');");
						break;
					case 'Leave':
						$sql->runQuery("DELETE FROM MemberTournament WHERE member_id ='$current_member_id' AND tournament_id='$tournament_id';");
						break;
					}
				}
				
				
				//Display all currently entered entrants
				//Keeps a count of how many entrants there are
				$result = $sql->runQuery("SELECT member_id FROM MemberTournament WHERE tournament_id = '$tournament_id';");
				while ($row = $result->fetch_assoc()) {
					$member_id = $row["member_id"];
					if($current_member_id == $member_id)
						$joined = true;
					$resultMembers = $sql->runQuery("SELECT player_tag FROM Member WHERE member_id = '$member_id';");
					while($rowMembers = $resultMembers->fetch_assoc()) {
						echo '<li>'.$rowMembers["player_tag"].'</li>';
					}
					$count = $count + 1;
				}
			?>
		</ol>
		
		<!--Number of entered players and max limit-->
		<br><label>Current Number of Players: <?php echo $count."/".$max_entries;?></label><br><br>
		
		<!--Displays join button if current user has not joined yet. Leave button if they have already joined. Displays
			"Full!" if the user has not joined but max limit of entrants have been reached.-->
		<?php
			if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<div id="player_tag" style="display: none;">'.$_SESSION["player_tag"].'</div>';
					echo '<div id="member_id" style="display: none;">'.$_SESSION["member_id"].'</div>';
					//Hidden html values used for Join and Leave functionality
					if(!$joined && $count < $max_entries)
						echo '<form action="tournament_create_bracket.php" method="get">
									<input type="hidden" name="action" value="Join">
									<input type="hidden" class="tournament_id" name="tournament_id" value="'.$tournament_id.'">
									<input type="submit" value="Join">
							</form>';
					else if(!$joined && $count >= $max_entries)
						echo '<label>Full!</label>';
					else
						echo '<form action="tournament_create_bracket.php" method="get">
									<input type="hidden" name="action" value="Leave">
									<input type="hidden" class="tournament_id" name="tournament_id" value="'.$tournament_id.'">
									<input type="submit" value="Leave">
							</form>';
				}
		?>
		
		<?php 
			//If admin is logged in, display "Save Bracket" button and "Close Sign Ups" button
			//"Close Sign Ups" button submits the tournaments' id to the display tournament page and redirects admin there.
			if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
					echo '<input type="button" class="finish-bracket" value="Save Bracket">'."<br>";
					echo'<form action="scripts/closeSignUp.php?tournament_id='.$tournament_id.'" method="post">
						<input type="submit" value="Close Sign Ups">
							</form>';
			}
		?>
		
		
		
<script>	
//Contains the current form of the bracket 
var saveData = <?php echo $bracket?>

function saveFn(data, userData) {
	 //Empty function
	 //Allows editing of bracket UI
}
	 
 /*Tournament initializer for admin*/
 //Allows editing of team names and size of bracket
$(function() {
	//Check if saveData = null
	if(saveData==null)
			saveData =  {
		teams : [
		  ["Team 1", "Team 2"], /* first matchup */
		  ["Team 3", "Team 4"]  /* second matchup */
		],
		results : [[0,0], [0,0]]
	  }
  
    var container = $('#tournament')
    container.bracket({
      init: saveData,
      save: saveFn,
      userData: "http://myapi"})
  })
  
 /*Tournament initialize for users or guests*/
 //Displays bracket and the inputed teams by the admin
 //Does not allow editing of the bracket UI
$(function() {
//Check if saveData = null
	if(saveData==null)
		saveData =  {
    teams : [
      ["Team 1", "Team 2"], /* first matchup */
      ["Team 3", "Team 4"]  /* second matchup */
    ],
    results : [[0,0], [0,0]]
  }
  
    var container = $('#tournamentUsers')
    container.bracket({
      init: saveData})
  })
</script>
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

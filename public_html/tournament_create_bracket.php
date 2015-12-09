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
	
	
		<h2><?php echo $_GET["title"]; ?></h2>

		<!--Bracket Display-->
		<div id="tournament"></div>
		
		<!--List of Entries and handling and finalize button-->
		<label>List of Entrants</label>
		<ol id="entrants">
			<?php 
			
				include_once ('../resources/sqlconnect.php');
				$tournament_id = $_GET["tournament_id"];
				$current_member_id = $_SESSION["id"];
				$joined = false;
				$count = 0;
				$sql = SqlConnect::getInstance();
				
				//Run either insert or delete queries per request
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
				$result = $sql->runQuery("SELECT member_id FROM MemberTournament WHERE tournament_id = '$tournament_id';");
				while ($row = $result->fetch_assoc()) {
					$member_id = $row["member_id"];
					if($current_member_id == $member_id)
						$joined = true;
					$resultMembers = $sql->runQuery("SELECT player_tag FROM Member WHERE member_id = '$member_id';");
					while($rowMembers = $resultMembers->fetch_assoc()) {
						echo '<li>'.$rowMembers["player_tag"].'</li>';
					}
				}
			?>
		</ol>
		
		<!--Displays join button if current user has not joined yet. Leave button otherwise -->
		<?php
			if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<div id="player_tag" style="display: none;">'.$_SESSION["player_tag"].'</div>';
					echo '<div id="member_id" style="display: none;">'.$_SESSION["member_id"].'</div>';
					if(!$joined)
						echo '<form action="tournament_create_bracket.php" method="get">
									<input type="hidden" name="action" value="Join">
									<input type="hidden" class="tournament_id" name="tournament_id" value="'.$tournament_id.'">
									<input type="submit" value="Join">
							</form>';
					else
						echo '<form action="tournament_create_bracket.php" method="get">
									<input type="hidden" name="action" value="Leave">
									<input type="hidden" name="title" value="'.$_GET["title"].'">
									<input type="hidden" class="tournament_id" name="tournament_id" value="'.$tournament_id.'">
									<input type="submit" value="Leave">
							</form>';
				}
		?>
		
		<?php 
			if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
					echo '<input type="button" class="finish-bracket" value="Finish Bracket">'."<br>";
					echo'<form action="tournaments_display.php?tournament_id='.$tournament_id["tournament_id"].'" method="post">
						<input type="submit" value="Close Sign Ups">
							</form>';
			}
		?>
		
		
		
	<script>	

	var saveData = {
		teams : [
		  ["Team 1", "Team 2"], /* first matchup */
		  ["Team 3", "Team 4"]  /* second matchup */
		],
		results : [[0,0], [0,0]]
	  }
	  

	/* Called whenever bracket is modified
	 *
	 * data:     changed bracket object in format given to init
	 * userData: optional data given when bracket is created.
	 */
	function saveFn(data, userData) {
	  //var json = jQuery.toJSON(data)
	  //$('#saveOutput').text('POST '+userData+' '+json)
	   /*$.ajax({
			url: 'scripts/saveTournament.php',
			type: 'POST',
			dataType: 'json',
			data: {tournament: json},
			success: function(data) 
				{
					console.log(data);
				}
		});*/
	}


	 
	$(function() {
		var container = $('#tournament')
		container.bracket({
		  init: saveData,
		  save: saveFn,
		  userData: "http://myapi"})
	  })
	  
	/*Skips the consolation round to determine 3rd and 4th place*/
	/*$(function() {
		$('div#noConsolationRound .demo').bracket({
		  skipConsolationRound: true,
		  init: doubleEliminationData})
	  })*/
	  </script>
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

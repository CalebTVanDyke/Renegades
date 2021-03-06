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
	$('.update-bracket').click(function(event){
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
		
	<!--Get bracket and other tournament info-->
	<?php
		include_once ('../resources/sqlconnect.php');
		$id=$_GET["tournament_id"];
		$sql = SqlConnect::getInstance();

		$result = $sql->runQuery("SELECT bracket,name, FROM Tournament WHERE tournament_id = '$id';");

		while ($row = $result->fetch_assoc()) {
			$bracket = $row["bracket"];
			$name = $row["name"];
		}
	?>
	
	<!-- Title-->
	<h2><?php echo $name;?></h2>
	
	<!--Displays tournament with different options depending on if the user is an admin or not-->
	<?php 
				if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
					echo '<div id="tournament"></div>';
					echo '<form> <input type="hidden" class="tournament_id" name="tournament_id" value="'.$id.'"></form>';
					echo "<br>".'<input type="button" class="update-bracket" value="Update Bracket">';
				}
				else
					echo '<div id="tournamentUsers"></div>';
			?>	


<script>
//Contains the current form of the bracket 
var saveData = <?php echo $bracket;?>
  
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

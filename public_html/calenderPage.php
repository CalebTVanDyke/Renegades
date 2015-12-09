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
	<link rel="stylesheet" type="text/css" media="all" href="css/calender.css">
	
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
			<li><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
			<li class="active"><a id="calenderPage" href="calenderPage.php">Calender</a></li>
			<?php 
				if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
					echo '<li><a id="profile" href="profile.php">Profile</a></li>';
				}
			?>
		</ul>
	<div id="content">
	</br>
	<button>Add Event</button>
	</br>
	<?php
		/* draws a calendar */
		function draw_calendar($month,$year){

			/* draw table */
			$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

			/* table headings */
			$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
			$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

			/* days and weeks vars now ... */
			$running_day = date('w',mktime(0,0,0,$month,1,$year));
			$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
			$days_in_this_week = 1;
			$day_counter = 0;
			$dates_array = array();

			/* row for week one */
			$calendar.= '<tr class="calendar-row">';

			/* print "blank" days until the first of the current week */
			for($x = 0; $x < $running_day; $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
				$days_in_this_week++;
			endfor;

			/* keep going with days.... */
			for($list_day = 1; $list_day <= $days_in_month; $list_day++):
				$calendar.= '<td class="calendar-day">';
					/* add in the day number */
					$calendar.= '<div class="day-number">'.$list_day.'</div>';

					/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
					$calendar.= str_repeat('<p> </p>',2);
					
				$calendar.= '</td>';
				if($running_day == 6):
					$calendar.= '</tr>';
					if(($day_counter+1) != $days_in_month):
						$calendar.= '<tr class="calendar-row">';
					endif;
					$running_day = -1;
					$days_in_this_week = 0;
				endif;
				$days_in_this_week++; $running_day++; $day_counter++;
			endfor;

			/* finish the rest of the days in the week */
			if($days_in_this_week < 8):
				for($x = 1; $x <= (8 - $days_in_this_week); $x++):
					$calendar.= '<td class="calendar-day-np"> </td>';
				endfor;
			endif;

			/* final row */
			$calendar.= '</tr>';

			/* end the table */
			$calendar.= '</table>';
			
			/* all done, return result */
			return $calendar;
		}

		/* sample usages */
		echo '<h2>December 2015</h2>';
		echo draw_calendar(12,2015);

		echo '<h2>January 2016</h2>';
		echo draw_calendar(1,2016);
	?>
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
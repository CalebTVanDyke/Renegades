<?php
session_start();
if (!isset($_SESSION["player_tag"]) || !isset($_SESSION["id"])) {
	header("Location: index.php");
	die();
}
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
                <li class=""><a id="home" href="index.php">Home</a></li>
                <li><a id="games" href="games.php">Games</a></li>
                <li><a id="tournaments" href="tournaments.php">Tournaments</a></li>
                <li><a id="leaderboards" href="leaderboards.php">Leaderboards</a></li>
				<li><a id="calenderPage" href="calenderPage.php">Calender</a></li>
                <?php
                    if (isset($_SESSION["player_tag"]) && isset($_SESSION["id"])) {
                        echo '<li class="active"><a id="profile" href="profile.php">Profile</a></li>';
                    }
                ?>
            </ul>
            <div id="content">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="centerBlock">
                            <img src="http://ui.uniteddogs.com/img/ui/user_icons/_no_avatar_f_180x180.png" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">Username and Bio and Position</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="short-div">Contact Info</div>
                        <div class="short-div">Games Owned</div>
                    </div>
                    <div class="col-sm-12 col-md-8">Recent Activity Log</div>
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
    </body>
</html>

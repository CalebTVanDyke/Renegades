<?php
session_start();
if (!isset($_SESSION["player_tag"]) || !isset($_SESSION["id"])) {
	header("Location: index.php");
	die();
}

include_once ('../resources/sqlconnect.php');

if (isset($_GET["user"])) {
	$id = $_GET["user"];
} else {
	$id = $_SESSION["id"];
}

$sql = SqlConnect::getInstance();

$query = "SELECT player_tag, email, avatar, description FROM Member m WHERE m.member_id = " . $id . ";";

$all_games = $sql->runQuery($query);

$user = $all_games->fetch_assoc();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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

        $('#profilePicture').hover(function() {
            $('#uploadProfilePictureButton').fadeIn();
        }, function() {
            $('#uploadProfilePictureButton').fadeOut();
        });

        $('#bio').hover(function() {
            $('#editBioButton').fadeIn();
        }, function() {
            $('#editBioButton').fadeOut();
        });
    });
    </script>
    </head>
    <style>
        #uploadProfilePictureButton{
            position:absolute;
            bottom:7px;
            right:70px;
        }
    </style>
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
                    <div class="col-sm-12 col-md-4" style="text-align: center;">
                        <div id="profilePicture" class="centerBlock">
                            <img src="http://ui.uniteddogs.com/img/ui/user_icons/_no_avatar_f_180x180.png" class="img-thumbnail">
                            <button id="uploadProfilePictureButton" class="btn btn-default" data-toggle="modal" data-target="#uploadProfilePicture" style="display: none;"> Change </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8" style="height: 100%;;">
                        <div class="panel panel-default" style="height: inherit;">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 style="margin-top: 0;"><?php echo $user["player_tag"];?></h2>
                                    </div>
                                </div>
                                <div class="row" id="bio">
                                    <div class="col-sm-11">
                                        <p>
                                            <?php
                                            if(strlen($user["description"]) > 0){
                                                echo $user["description"];
                                            }
                                            else{
                                                echo "No Bio";
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-1">
                                        <button id="editBioButton" class="btn btn-default" data-toggle="modal" data-target="#editBio" style="display: none;"> Change </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="short-div" style="text-align: center;">
                            <br>
                            <?php
                            echo $user["email"];
                            ?>
                        </div>
                        <div class="short-div" style="text-align: center;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <br>
									<?php
										if (isset($_SESSION["id"]) && $id == $_SESSION["id"])
                                    		echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addGame">Edit Games</button>';
									?>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <h3>My Games</h3>

                            <?php
                            $user_games = $sql->runQuery("SELECT mg.game_id, g.name, g.image_name FROM MemberGame mg INNER JOIN Game g ON mg.game_id = g.game_id WHERE mg.member_id = ". $_SESSION['id'] .";");

                            while($row = $user_games->fetch_assoc()){
                                echo '<div class="row"> <div class="col-sm-4">';
                                echo '<img class="img-responsive" src="../resources/game_images/'.$row['image_name'].'" alt="">';
                                echo '</div>';
                                echo '<div class="col-sm-8">';
                                echo '<span><a href="games.php?game='. $row['name'] .'">'. $row['name'] .'</a></span>';
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';
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
                        <form id="addGameForm" action="scripts/addGameToProfile.php" method="POST" enctype="multipart/form-data">
                            <?php
                            $all_games = $sql->runQuery("SELECT game_id, name FROM Game;");

                            $user_games = $sql->runQuery("SELECT game_id FROM MemberGame WHERE member_id = ". $_SESSION['id'] .";");
                            $user_games_array = array();

                            while($row = $user_games->fetch_assoc()){
                                array_push($user_games_array, $row['game_id']);
                            }
                            //echo count($user_games_array);

                            while ($row = $all_games->fetch_assoc()) {
                                if(in_array($row['game_id'], $user_games_array)){
                                    echo '<div class="form-group">';
                                    echo '<label><input type="checkbox" name="game' . $row['game_id'] . '" value="' . $row['game_id'] . '" checked>' . $row['name'] . '</label>';
                                    echo '</div>';
                                }
                                else{
                                    echo '<div class="form-group">';
                                    echo '<label><input type="checkbox" name="game' . $row['game_id'] . '" value="' . $row['game_id'] . '">' . $row['name'] . '</label>';
                                    echo '</div>';
                                }

                            }
                            ?>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" form="addGameForm" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="uploadProfilePicture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Change Profile Picture</h4>
                    </div>
                    <div class="modal-body">
                        <form id="uploadProfilePictureForm" action="scripts/uploadProfilePicture.php" method="POST" enctype="multipart/form-data">
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
        <!-- Modal -->
        <div class="modal fade" id="editBio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Change Bio</h4>
                    </div>
                    <div class="modal-body">
                        <form id="editBioForm" action="scripts/editBio.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Bio</label>

                                    <?php
                                    $result = $sql->runQuery("SELECT description FROM Member WHERE member_id=". $_SESSION['id'] .";");
                                    $row = $result->fetch_assoc();

                                    $bio =  $row['description'];
                                    ?>
                                <textarea name="bio" type="text" class="form-control"><?php echo $bio ?></textarea>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" form="editBioForm" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

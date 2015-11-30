<?php 

include_once ('../../resources/sqlconnect.php');

$title = mysqli_real_escape_string($_POST["title"]);
$release = $_POST["releaseDate"];
$description = mysqli_real_escape_string($_POST["description"]);
$genre = mysqli_real_escape_string($_POST["genre"]);
$maxPlayers = $_POST["maxPlayers"];

$sql = SqlConnect::getInstance();
$query = "INSERT INTO Game (name, genre, release_date, description, max_players) VALUES ('".$title."','".$genre."','".$release."','".$description."','".$maxPlayers."');";
$sql->runQuery($query);

$target_dir = "../../resources/game_images/";
$target_file = $target_dir . $_POST["title"] . ".jpg";

if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	echo "The file ". $target_file . " has been uploaded.";
}

?>
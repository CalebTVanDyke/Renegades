<?php
// Adds the specified game to the database and saves the image into the correct folder
include_once ('../../resources/sqlconnect.php');

$sql = SqlConnect::getInstance();
$title = $sql->escape($_POST["title"]);
$release = $_POST["releaseDate"];
$description = $sql->escape($_POST["description"]);
$genre = $sql->escape($_POST["genre"]);
$maxPlayers = $_POST["maxPlayers"];
$fileName = basename($_FILES["image"]["name"]);

$query = "INSERT INTO Game (name, genre, release_date, description, max_players, image_name) VALUES ('".$title."','".$genre."','".$release."','".$description."','".$maxPlayers."', '".$fileName."');";
$sql->runQuery($query);

$target_dir = "../../resources/game_images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);;

if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	echo "The file ". $target_file . " has been uploaded.";
}
header('Location: ../games.php?game=' . $title);
die();
?>

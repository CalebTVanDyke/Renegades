<?php
// Edits the specified game to the database and saves the image into the correct folder if a new image was uploaded
include_once ('../../resources/sqlconnect.php');

$sql = SqlConnect::getInstance();
$title = $sql->escape($_POST["title"]);
$release = $_POST["releaseDate"];
$description = $sql->escape($_POST["description"]);
$genre = $sql->escape($_POST["genre"]);
$maxPlayers = $_POST["maxPlayers"];
$id = $_POST["id"];
if ($id == "" || $title == "" || $release == "" || $description == "" || $genre == "" || $maxPlayers == "") {
    header('Location: ../games.php?error=' . "Please fill in all fields in the form.");
    die();
}
if (isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
    $fileName = basename($_FILES["image"]["name"]);
    $query = "UPDATE Game SET name='".$title."', genre='".$genre."', release_date='".$release."', description='".$description."', max_players='".$maxPlayers."', image_name='".$fileName."' WHERE game_id=" . $id . ";";

    $target_dir = "../../resources/game_images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);;

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    	echo "The file ". $target_file . " has been uploaded.";
    }
} else {
    $query = "UPDATE Game SET name='".$title."', genre='".$genre."', release_date='".$release."', description='".$description."', max_players='".$maxPlayers."' WHERE game_id=" . $id . ";";
}
echo $query;
$sql->runQuery($query);

header('Location: ../games.php?game=' . $title);
die();
?>

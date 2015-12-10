<?php
// Delete the specified game from the database
include_once ('../../resources/sqlconnect.php');
$sql = SqlConnect::getInstance();

$game = $_GET["toDelete"];

$sql->runQuery("DELETE FROM Game where game_id=" . $game . ";");

header('Location: ../games.php');
die();

?>

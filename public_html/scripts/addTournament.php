<?php
$max_size = $_GET["entrants"];
$price = $_GET["price"];
$name = $_GET["title"];
$type = $_GET["type"];
$date = $_GET["date"];
$game = $_GET["game"];

include_once ('../../resources/sqlconnect.php');

$sql = SqlConnect::getInstance();
//Insert tournament
$query = "INSERT INTO Tournament (entries, date, tournament_type, price, game_id, name,open,bracket) VALUES ('".$max_size."','".$date."','".$type."','".$price."','".$game."', '".$name."',1,'empty');";
$sql->runQuery($query)

//Get Tournament id
$query = "SELECT tournament_id FROM Tournament WHERE name='$name' AND date='$date'";
$result = $sql->runQuery($query)
$id = -1;

while ($row = $result->fetch_assoc()) {
	$id = $row["tournament_id"];
}

header('Location: ../tournament_create_bracket.php?tournament_id=' . $id);
die();
?>
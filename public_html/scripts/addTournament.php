<?php
$max_size = $_GET["entrants"];
$price = $_GET["price"];
$name = $_GET["title"];
$type = $_GET["type"];
$date = $_GET["date"];
//Set to a default bracket value
$bracket = '{"teams":[["Team 1","Team 2"],["Team 3","Team 4"]],"results":[[[[0,0],[0,0]]]]}';
//Reverse date for db format
$date = strrev($date);
$game_id = $_GET["game_id"];

//Database connection file
include_once ('../../resources/sqlconnect.php');
$sql = SqlConnect::getInstance();

//Insert tournament
$query = "INSERT INTO Tournament (entries, date, tournament_type, price, game_id, name,open,bracket) VALUES ('$max_size','$date','$type','$price','$game_id', '$name',1,'$bracket');";
$sql->runQuery($query);

//Get Tournament id
$query = "SELECT tournament_id FROM Tournament WHERE name='$name' AND date='$date'";
$result = $sql->runQuery($query);
$id = -1;

while ($row = $result->fetch_assoc()) {
	$id = $row["tournament_id"];
}

//Debugging purposes
echo "max size".$max_size."<br>price".$price."<br>name".$name."<br>type".$type."<br>date".$date."<br>game id".$game;

//Redirect to tournament create bracket page with id of tournament just created
header('Location: ../tournament_create_bracket.php?tournament_id=' . $id);
die();
?>
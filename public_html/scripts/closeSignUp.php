<?php
$tournament_id = $_GET["tournament_id"];

include_once ('../../resources/sqlconnect.php');

$sql = SqlConnect::getInstance();

$sql->runQuery("UPDATE Tournament SET open=0 WHERE tournament_id='$tournament_id';");

header('Location: ../tournaments_display.php?tournament_id=' . $tournament_id);
die();
?>
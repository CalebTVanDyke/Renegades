<?php

include_once ('../../resources/sqlconnect.php');

$id = $_GET['id'];
$val = $_GET['setTo'];

$sql = SqlConnect::getInstance();
$query = "UPDATE Game SET featured=" . $val . " WHERE game_id=" . $id . ";";
$sql->runQuery($query);
?>

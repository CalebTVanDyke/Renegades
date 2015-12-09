<?php

include_once ('../../resources/sqlconnect.php');
$bracket = $_GET["bracket"];
$id=$_GET["tournament_id"];
$sql = SqlConnect::getInstance();

$sql->runQuery("UPDATE Tournament SET bracket='$bracket', open=0 WHERE tournament_id='$id';");
echo $id."<br>";
echo json_encode($bracket);
?>
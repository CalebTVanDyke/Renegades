<?php

include_once ('../../resources/sqlconnect.php');

session_start();

$sql = SqlConnect::getInstance();
$result = $sql->runQuery("UPDATE Member SET description='". $_POST['bio'] ."' WHERE member_id='". $_SESSION["id"] ."';");

header("Location: ../profile.php");
die();

?>
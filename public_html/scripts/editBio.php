<?php

include_once ('../../resources/sqlconnect.php');

session_start();
//Update user information with new bio
$sql = SqlConnect::getInstance();
$result = $sql->runQuery("UPDATE Member SET description='". $_POST['bio'] ."' WHERE member_id='". $_SESSION["id"] ."';");

//redirect back to profile page
header("Location: ../profile.php");
die();

?>
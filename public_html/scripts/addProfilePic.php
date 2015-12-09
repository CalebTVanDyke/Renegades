<?php

include_once ('../../resources/sqlconnect.php');
session_start();
$sql = SqlConnect::getInstance();
$fileName = basename($_FILES["image"]["name"]);

$query = "UPDATE Member SET avatar='".$fileName."' WHERE member_id = ".$_SESSION['id'].";";
echo $query;
$sql->runQuery($query);

$target_dir = "../../resources/avatars/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);;

if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	echo "The file ". $target_file . " has been uploaded.";
}
header('Location: ../profile.php');
die();
?>

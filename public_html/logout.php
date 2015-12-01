<?php 
include_once ('../resources/User.php');
User::logout();
header("Location: index.php");
exit();
?>
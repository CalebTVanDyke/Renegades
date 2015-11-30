<?php 

include_once ('../resources/User.php');

$user = new User("root", "root", "email");
echo $user->login();
 ?>
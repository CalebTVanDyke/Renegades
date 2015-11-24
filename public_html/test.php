<?php 

include_once ('../resources/User.php');

$user = new User("root", "0", "email");
echo $user->login();
 ?>
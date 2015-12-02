<?php 
$fp = fopen('/dev/urandom', 'r');
$randomString = base64_encode(fread($fp, 32));
fclose($fp);
 ?>

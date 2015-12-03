<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 01/12/15
 * Time: 20:17
 */

include_once ('../../resources/sqlconnect.php');

session_start();

$sql = SqlConnect::getInstance();
$result = $sql->runQuery("SELECT game_id FROM Game;");

while($row = $result->fetch_assoc()){
    $name = 'game' . $row['game_id'];

    if(isset($_POST[$name])){
        $sql->runQuery("INSERT IGNORE INTO MemberGame (member_id, game_id) VALUES ('".$_SESSION["id"]."','".$_POST[$name]."');");
    }
    else{
        $sql->runQuery("DELETE FROM MemberGame WHERE member_id=". $_SESSION["id"] ." AND game_id=". $row['game_id'] .";");
    }

}

header("Location: ../profile.php");
die();

?>
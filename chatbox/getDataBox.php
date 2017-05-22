<?php

include_once ("../includes/database.php");
include_once ("../includes/classes.php");

$db = new DatabaseIcen();
$functions = new functions();
$dif = 0;
$sql = "SELECT * FROM chatbox ORDER BY id ASC";
$count_users = $db->query($sql)->num_rows;
if($count_users > 10){
    $dif = $count_users - 10;
}

$users = $db->query("SELECT * FROM chatbox ORDER BY id ASC LIMIT $dif,$count_users");
if($users->num_rows > 0){
    while ($row = $users->fetch_assoc()){
        if(strpos($row["text"], '@') !== false){
            $pos = strpos($row["text"], '@');

        }
        $functions->chatFormat($row["data_hora_enviada"],$row["username"],$row["text"]);
    }
}


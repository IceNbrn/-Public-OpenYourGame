<?php
session_start();
if(isset($_REQUEST['m']) && isset($_SESSION["userId"])) {

    include_once("../includes/database.php");
    include_once("../includes/classes.php");
    $db = new DatabaseIcen();
    $functions = new functions();



    $username = $db->getName($_SESSION["userId"]);
    $msg = $db->quote($_REQUEST['m']);

    echo $msg;
    $id = 0;
    $data_hora_enviada = $functions->gethoraData();

    $sql = "INSERT INTO chatbox (username,text,data_hora_enviada) VALUES ('" . $username . "','" . $msg . "','" . $data_hora_enviada . "')";

    $db->query($sql);


}

?>
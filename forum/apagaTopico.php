<?php
session_start();
if(isset($_SESSION["userId"]) && isset($_REQUEST['id'])) {
    include_once("../includes/database.php");
    $db = new DatabaseIcen();
    $id = $db->quote($_REQUEST['id']);
    if($db->isAdmin($_SESSION["userId"]) > 1 || $db->topicoIsFromUser($_SESSION["userId"],$id)){




        $sql = "DELETE FROM topicos WHERE ID_Topico = $id";
        $sql1 ="DELETE FROM respostas WHERE ID_Topico = $id";

        $db->query($sql);
        $db->query($sql1);
        header("Location: index");
    }
}


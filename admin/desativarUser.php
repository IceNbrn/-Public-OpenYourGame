<?php
session_start();
if(isset($_SESSION["userId"]) && isset($_REQUEST['u'])) {
    include_once("../includes/database.php");
    $db = new DatabaseIcen();
    if($db->isAdmin($_SESSION["userId"]) == 1){

        $idUser = $db->quote($_REQUEST['u']);


        $sql = "UPDATE utilizadores SET eliminado = 1 WHERE id_utilizador = $idUser";

        $users = $db->query($sql);

    }
}


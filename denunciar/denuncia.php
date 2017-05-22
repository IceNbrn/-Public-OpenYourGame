<?php
session_start();
if(isset($_REQUEST['t']) && isset($_SESSION["userId"]) && isset($_REQUEST['u'])) {

    if(!empty($_REQUEST['t']) && !empty($_REQUEST['u'])) {


        include_once("../includes/database.php");
        include_once("../includes/classes.php");
        $db = new DatabaseIcen();
        $functions = new functions();

        $userLogado = $_SESSION['userId'];
        $idUser = $db->quote($_REQUEST['u']);
        $texto = $db->quote($_REQUEST['t']);
        $db->denunciaJogador($userLogado, $idUser, $texto);
    }
}
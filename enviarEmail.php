<?php
include_once ("includes/classes.php");
include_once ("includes/database.php");
if(isset($_GET["email"]) && isset($_GET["secrect"])){
    $db = new DatabaseIcen();
    $email = $db->quote($_GET["email"]);
    $secrect = $db->quote($_GET["secrect"]);
    $functions = new functions();
    $functions->enviarEmail($email,false,$secrect);
    header("Location: http://localhost/OpenYourGame/");
}
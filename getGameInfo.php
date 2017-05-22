<?php
if (isset($_POST['selectData'])) {
    include_once ("includes/database.php");
    $id = $_POST['selectData'];
    $db = new DatabaseIcen();
    $db->getGames_ID($id);
}
?>
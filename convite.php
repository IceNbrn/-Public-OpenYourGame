<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <script src="js/sweetalert.min.js"></script>
</head>
<body>

<?php
ob_start();
session_start();
include_once ("includes/classes.php");
$functions = new functions();
$functions->isLogged($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
include_once ("includes/database.php");
$db = new DatabaseIcen();
$idLogado = $_SESSION["userId"];
$pagina = 1;
if(isset($_GET["id"]) && isset($_GET["estado"])){
    $idConvite = $_GET["id"];
    $estado = $_GET["estado"];
    $mensagem = "";
    if($estado == "Aceitar"){
        $sql = "UPDATE convites SET estado = 'Aceite' WHERE id_Convite = $idConvite";
        $mensagem = "Convite aceite!";
    }
    if($estado == "Recusar"){
        $sql = "UPDATE convites SET estado = 'Recusado' WHERE id_Convite = $idConvite";
        $mensagem = "Convite recusado!";
    }
    $db->query($sql);
    //echo "<script>swal('Convite', '$mensagem', 'success');</script>"
    echo "<script>
    swal({
      title: \"Convite\",
      text: \"$mensagem!\",
      type: \"info\",
      showCancelButton: false,
      confirmButtonColor: \"#DD6B55\",
      confirmButtonText: \"OK\",
      closeOnConfirm: false,
    },
    function(isConfirm){
      if (isConfirm) {
        window.location = 'convites.php';
      } 
    });
    </script>";
}
?>
</body>
</html>
<?php
ob_start();
session_start();
include_once ("includes/classes.php");
$functions = new functions();
$functions->isLogged($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
?>
<!DOCTYPE html>

<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link rel="stylesheet" href="css/select.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="js/sweetalert.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">

</head>

<body>
<?php

include_once("includes/database.php");
$db = new DatabaseIcen();
if(!$db->steamConnection($_SESSION["userId"])) {
    echo '<script>
    swal({
      title: "Erro",
      text: "Não tens a conta conectada com a steam!",
      type: "error",
      confirmButtonColor: "#dd352e",
      confirmButtonText: "Ok",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        window.location = "index.php";
      }
    });
    </script>';
    return;
}
?>
<?php
include_once("includes/menu.php");
$titulo = "Novo Jogo";
include_once("includes/banner.php");
?>


<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <img id="imagemOfGame" name="imagemOfGame">

        <h2>
            Novo jogo
        </h2>
        <div class="row">
            <div class="select">
                <form action="novoJogo.php" method="post">
                    <select name="select" id="select">
                        <?php

                            $sql = "SELECT * FROM jogos WHERE id_jogo <> -1";

                            $jogos = $db->query($sql);


                            if($jogos->num_rows >0){
                                while ($row = $jogos->fetch_assoc()){

                                    $nameOfGame = $row["nome"];
                                    $idJogo = $row["id_jogo"];
                                    echo "<option value=".$idJogo.">$nameOfGame</option>";
                                }
                            }
                            else{
                                echo "<option>Não existem jogos na base de dados!</option>";
                            }
                        ?>
                    </select>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Adicionar</button>
                </form>

            </div>
            <?php
            if(isset($_POST['submit'])){
                $idJogo = $_POST["select"];
                $steamid = $db->userSteamLinked($_SESSION["userId"]);
                include_once ("includes/classes.php");
                $functions = new functions();
                $db->addEstatisticasJogo($idJogo,$_SESSION["userId"],$steamid);
            }
            ?>
        </div>

        <?php include_once("includes/footer.php"); ?>
    </div>
    </div>

</body>

</html>

<?php
ob_start();
session_start();
include_once ("../includes/classes.php");

$functions = new functions();
$functions->manutencao($_SESSION["userId"]);
$jogo = null;
?>

<?php
    include_once ("../includes/database.php");
    $db = new DatabaseIcen();

    if (isset($_GET["jogo"])) {

        $jogo = $_GET["jogo"];
        $gameID = $db->getGamesIDWithNome($jogo);
        if ($gameID == 0) {
            header("location: index.php");
        }
    }
    else{
        header("location: ../login.php");
    }
    ?>

<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Adicionar Tópico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="../images/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/second.css">
    <link rel="stylesheet" href="../css/select.css">
    <link rel="stylesheet" href="../css/forum_style.css">
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="../js/sweetalert.min.js"></script>
    <style>
        .breadcrumb{
            color: #1b1b1b;
        }
    </style>
</head>

<body>

<?php
include_once("menu.php");
$titulo = $jogo. " - Forum";
include_once("../includes/banner.php");
?>
<div class="container-fluid containerSpace">
        <div class="page-header" id="banner">
        <!--<h1> - Forum</h1>-->
        <h2>Adicionar Tópico:</h2>
            <div class="breadcrumb" id="AdicionarTopico">
                <form method="post" style="align:center" action="adicionarTopico?jogo=<?= $_GET["jogo"]?>">
                    Categoria: <div class="select"><select name="select_perfil" id="perfil_select">
                                <?php

                                $sql = "SELECT * FROM categorias ORDER BY Nome DESC";

                                $categorias = $db->query($sql);

                                if($categorias->num_rows >0){
                                    while ($row = $categorias->fetch_assoc()){

                                        $nome = $row["Nome"];

                                        echo "<option value=".$nome.">$nome</option>";
                                    }
                                }
                                else{
                                    echo "<option>Ocorreu um erro no servidor..</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <p></p>
                    <input class="form-control" name="topico" placeholder="Nome do Tópico (tenho um tal problema/duvida, isto aconteceu-me, etc.)">
                <br>
                <li>
                    <input class="form-control" placeholder="(isto não é obrigatório, mas é fortemente recomendado que especifiques aqui o teu problema/duvida)" size="156" name="descricao" style="overflow: hidden; height: 80px;">
                </li>
                <p></p>
                    <input class="btn btn-primary" style="background-color:#1b1b1b; !important;" type="submit" name="Adicionar" value="Adicionar">
                    <?php
                    if (isset($_POST["Adicionar"])) {
                        if (isset($_SESSION["userId"])) {

                            $jogo = $db->quote($_GET["jogo"]);
                            $topico = $db->quote($_POST["topico"]);
                            $descricao = $db->quote($_POST["descricao"]);
                            $userId = $_SESSION["userId"];
                            $selectedCategoria = $db->quote($_POST["select_perfil"]);
                            $gameID = $db->getGamesIDWithNome($jogo);

                            if (empty($topico)) {
                                echo '<script>swal("Oops!", "Por favor, preencha pelo menos o nome do problema/duvida", "error");</script>';
                                exit;
                            }

                            if($db->verificaTopicoDescricao($topico,$descricao)) {
                                echo '<script>swal("Oops!", "Já existe um problema/duvida com os mesmo dados !", "error");</script>';
                                exit;
                            }

                            $sql="INSERT INTO topicos (ID_Topico,Nome,Descricao,ID_Utilizador,ID_Jogo,Categoria) VALUES(0,'$topico','$descricao',$userId,$gameID,'$selectedCategoria')";

                            $db->query($sql);

                            echo '<script>swal("Tópico!", "Adicionas-te um tópico à nossa comunidade :D !!", "success");</script>';
                        }
                        else{
                            header("Location: ../login.php");
                        }
                    }
                    ?>
                </form>    
            </div>
        </div>
    </div>
</body>
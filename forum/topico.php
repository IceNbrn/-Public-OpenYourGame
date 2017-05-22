<?php
ob_start();
session_start();

include_once ("../includes/classes.php");
$functions = new functions();
include_once ("../includes/database.php");


if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
$userLogado = null;
$db = new DatabaseIcen();
if(isset($_GET["id"])){
    $id = $db->quote($_GET["id"]);
    if(!$db->existTopico($id)){
        header("Location: ../error404");

    }

    if(isset($_SESSION["userId"]))
        $userLogado = $_SESSION["userId"];
    else
        $userLogado = null;

    if(isset($_POST["comentar"]) && $userLogado != null){
        if(!empty($_POST["comentario"])){
            $comentario = $db->quote($_POST["comentario"]);
            $db->novoComentario($id,$userLogado,$comentario);
        }else{
            $functions->alert("success","Tens de escrever o comentário!","Erro");
        }


    }
}else{
    header("Location: index");
}
?>

<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Foruns </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="icon" href="../images/icon.png" type="image/x-icon" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/second.css">
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">


    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="../js/sweetalert.min.js"></script>
</head>


<body id="all">
<?php
include_once("menu.php");
$titulo = "Topico";
include_once("../includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">

        <?php

        $topico = $db->getTopico($id);
        $nomeTopico = $topico["Nome"];
        $descricao = $topico["Descricao"];
        $dataHora = $topico["datahora"];
        $autor = $db->getName($topico["ID_Utilizador"]);
        $categoria = $topico["Categoria"];


        $splitHoraData = explode(" ",$dataHora);
        $hora = $splitHoraData[1];

        setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
        date_default_timezone_set('Europe/London');

        $dataTexto = strftime('%A, %d de %B de %Y', strtotime($dataHora)) . " às $hora";
        ?>
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-12">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?= $nomeTopico?> &nbsp
                    <?php if($userLogado != null){if($db->isAdmin($userLogado) || $db->topicoIsFromUser($userLogado,$id)){?>
                    <a href="apagaTopico?id=<?=$id?>">
                        <span style="font-size: 20px" class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                    <?php }}?>
                </h1>

                <!-- Author -->
                <p class="lead">
                    por <a href="../perfil?username=<?= $autor?>"><?= $autor ?> </a>em <?= $categoria?>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Publicado <?= $dataTexto?></p>

                <hr>

                <!-- Post Content -->
                <h4><?= $descricao?></h4>
                <hr>

                <!-- Blog Comments -->

                <!-- Formulário do form -->
                <div class="well">
                    <h4 style="color: #242727">Comenta:</h4>
                    <form action="topico.php?id=<?=$id?>" method="post">
                        <div class="form-group">
                            <textarea id="comentario" name="comentario" class="form-control"></textarea>
                        </div>
                        <input type="submit" value="Comentar" name="comentar" id="comentar" class="btn btn-primary" <?php if($userLogado == null) echo "disabled";?>>
                    </form>
                </div>

                <hr>

                <!-- Comentários -->

                <?php $db->getRespostas($id); ?>

            </div>



        </div>
        <?php include_once("../includes/footer.php"); ?>
    </div>
</body>
</html>
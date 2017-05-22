<?php
ob_start();
session_start();
include_once ("includes/classes.php");
$functions = new functions();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Escolhe o teu jogador">
    <meta name="keywords" content="JOGO,GAME,ABRE,OPEN,ESCOLHE,ESPORTS,PORTUGAL,OpenYourGame">
    <meta name="author" content="IceN">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    <title>OYG - Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/teste.css">


    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body id="all">

<?php
include_once("includes/menu.php");
$titulo = "Bem vindo ao futuro do eSport Português";
include_once("includes/banner.php");

?>


<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <?php
        if(isset($_COOKIE['sucesso'])){
            if($_COOKIE['sucesso'] == "sucesso"){
                echo "<h2 style='color: greenyellow'>Conectado ao steam com sucesso!</h2>";
                setcookie("sucesso", "sucesso", time() - 86400, "/");
            }
        }
        ?>
        <h2>
            JOGOS EM DESTAQUE
        </h2>

        <?php
        include_once("includes/database.php");
        $db = new DatabaseIcen();

        ?>
        <div class="row">
            <?php
            $db->getGames();
            ?>
            <div class="col-md-4" style="padding-top: 15px">
                <div class="hovereffect">
                    <img alt="" class="img-responsive" src="images/modeloOYG.png">
                    <div class="overlay">
                        <h2>
                            <a href="#">Mais Jogos em breve!</a>
                        </h2>
                    </div>
                    </img>
                </div>
            </div>
        </div>
        <?php include_once("includes/footer.php"); ?>


    </div>
</body>
</html>


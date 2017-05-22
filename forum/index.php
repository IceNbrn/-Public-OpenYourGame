<?php
ob_start();
session_start();
include_once ("../includes/classes.php");
$functions = new functions();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
?>

<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Foruns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="../images/icon.png" type="image/x-icon" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/second.css">


    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
</head>


<body id="all">
<?php
include_once("menu.php");
$titulo = "Foruns";
include_once("../includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">


        <?php
        include_once("../includes/database.php");
        $db = new DatabaseIcen();

        ?>
        <div class="row">
            <?php
            $db->getGamesForuns();
            ?>
            <div class="col-md-4" style="padding-top: 15px">
                <div class="hovereffect">
                    <img alt="" class="img-responsive" src="images/modeloOYG.png">
                    <div class="overlay">
                        <h2>
                            <a href="forum?jogo=OFFTOPIC">Off Topico</a>
                        </h2>
                    </div>
                    </img>
                </div>
            </div>
            <div class="col-md-4" style="padding-top: 15px">
                <div class="hovereffect">
                    <img alt="" class="img-responsive" src="images/modeloOYG.png">
                    <div class="overlay">
                        <h2>
                            Mais Jogos em breve!
                        </h2>
                    </div>
                    </img>
                </div>
            </div>
        </div>
        <?php include_once("../includes/footer.php"); ?>
    </div>
</body>
</html>
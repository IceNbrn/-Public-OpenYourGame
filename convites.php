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
$idConvite = null;
$ver = null;
if(isset($_GET["id"])){
    $idConvite = $_GET["id"];
    if (isset($_GET["p"])) {
    if($_GET["p"] == 0){
            $pagina = 1;
        }else{
            $pagina = $db->quote($_GET["p"]);
        }
        
    }
    if(isset($_POST["Ver"]) && isset($_SESSION["userId"])){

        $estado = $db->quote($_POST["estado"]);
        $ver = true;

    }

}
?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Convites</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/jogadores.css">
    <link rel="stylesheet" href="css/select.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body>
<?php
include_once("includes/menu.php");
$titulo = "Convites";
include_once("includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <?php
        include_once("includes/database.php");
        $db = new DatabaseIcen();

        ?>
        <form action="convites?id=<?= $idLogado?>" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <p>Estado:</p>
                        <div class="select">
                            <select name="estado" id="estado">
                                <option value="Aceite">Aceite</option>
                                <option value="Pendente">Pendente</option>
                                <option value="Recusado">Recusado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <input class="btn btn-primary btn-lg" type="submit" id="Ver" name="Ver" value="Ver">
            <hr>
        </form>
        <h2 style="color: green">Histórico de Convites <?php if($db->getConvitesPendentes($idLogado)) echo "*";?></h2>


        <div class="row">
            <?php
            if($ver)
                $db->getConvites($pagina,$idLogado,$estado);
            else
                $db->getConvites($pagina,$idLogado);

            ?>
        </div>
            <div class="row">
                <?php
                $numToShow = 20;

                if($ver){
                    $sql = "SELECT * FROM convites WHERE (id_utilizadorConvidado = $idLogado OR id_utilizador = $idLogado) AND estado = '$estado'";
                }else{
                    $sql = "SELECT * FROM convites WHERE (id_utilizadorConvidado = $idLogado OR id_utilizador = $idLogado)";
                }
                $convites = $db->query($sql);



                $total_records = $convites->num_rows;
                $total_pages = ceil($total_records / $numToShow);
                echo "<ul class='pager'>";
                $paginaTraz = $pagina - 1;
                $paginaFrente = $pagina + 1;
                echo "<li class='previous_'> <a href='convites?id={$idConvite}&p={$paginaTraz}'><span aria-hidden='true'>&larr;</span>Anterior</a> </li>";
                for ($i=1; $i<=$total_pages; $i++) {
                    echo "
                    
                  <li class='next_'><a href='convites?id={$idConvite}&p=".$i."'><span aria-hidden='true'></span>$i</a></li>

                ";

                };
                echo "<li class='next_'> <a href='convites?id={$idConvite}&p={$paginaFrente}'><span aria-hidden='true'>&rarr;</span>Proxima</a> </li></ul>";
                ?>
            </div>
        <?php include_once("includes/footer.php"); ?>
    </div>

</body>
</html>

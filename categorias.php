<?php
ob_start();
session_start();

include_once("includes/database.php");
include_once("includes/classes.php");
$functions = new functions();
$db = new DatabaseIcen();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
$functions->isLoggedAndAdmin($_SESSION["userId"]);
$pagina = 1;


?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Categorias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="js/sweetalert.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

</head>

<body>
<?php
if(isset($_SESSION["userId"])){


    if(isset($_REQUEST['rcid'])) {

        if($db->isAdmin($_SESSION["userId"]) == 1){

            if (isset($_GET["p"])) {

                if($_GET["p"] == 0){
                    $pagina = 1;
                }else{
                    $pagina = $db->quote($_GET["p"]);
                }
            }

            $nome = $db->quote($_REQUEST['rcid']);

            $sql = "DELETE FROM categorias WHERE Nome = '{$nome}'";

            $db->query($sql);

            //echo '<script>swal("Categorias", "A categoria foi apagada.", "success");</script>';

            header("Location: categorias");
        }
    }

}
?>
<?php include_once("includes/menu.php");
$titulo = "Categorias";
include_once("includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">

        <?php include_once("includes/menu_admin.php");?>
        <div class="row">
            <a href="adicionarCategoria" class="pull-right"><h3 style="color: #ffa700 !important;" >Nova Categoria <span class="glyphicon glyphicon-plus" ></span></h3></a>
        </div>
        <div class="row">

            <?php
            $db->getCategorias($pagina);
            ?>

        </div>
        <div class="row">
            <?php
                $numToShow = 20;
                $sugestoes = $db->query("SELECT * FROM categorias");
                $total_records = $sugestoes->num_rows;
                $total_pages = ceil($total_records / $numToShow);
                echo "<ul class='pager'>";
                $paginaTraz = $pagina - 1;
                $paginaFrente = $pagina + 1;
                echo "<li class='previous_'> <a href='categorias?p={$paginaTraz}'><span aria-hidden='true'>&larr;</span>Anterior</a> </li>";
                for ($i=1; $i<=$total_pages; $i++) {
                    echo "
                    
                  <li class='next_'><a href='categorias?p=".$i."'><span aria-hidden='true'></span>$i</a></li>

                ";

                };
                echo "<li class='next_'> <a href='categorias?p={$paginaFrente}'><span aria-hidden='true'>&rarr;</span>Proxima</a> </li></ul>";
            ?>
        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
</body>
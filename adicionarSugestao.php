<?php
ob_start();
session_start();
include_once ("includes/classes.php");
include_once ("includes/database.php");
$functions = new functions();
$functions->isLogged($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);

$db = new DatabaseIcen();
?>

<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Escolhe o teu jogador">
    <meta name="keywords" content="JOGO,GAME,ABRE,OPEN,ESCOLHE,ESPORTS,PORTUGAL,OpenYourGame">
    <meta name="author" content="IceN">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    <title>OYG - Adicionar Sugestão</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/teste.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <script src="js/sweetalert.min.js"></script>
</head>

<body>
<?php
include_once("includes/menu.php");
$titulo = "Ajuda a comunidade a crescer";
include_once("includes/banner.php");

?>
    <div class="container-fluid containerSpace">
        <div class="page-header" id="banner">
        <h2>Adicionar Sugestão:</h2>
            <div class="breadcrumb" id="AdicionarSugestao">
                <form method="post" style="align:center" action="adicionarSugestao">
                    <div class="select">
                        <select name="categoria" id="categoria">
                            <option>Sugestão</option>
                            <option>Jogo</option>
                            <option>Bug/Glitch</option>
                        </select>
                    </div>

                    <textarea class="form-control" name="texto" placeholder="As sugestões têm como objetivo ajudar tanto na manutencao do site tanto como a comunidade."></textarea>
                <br>
                <p></p>
                    <input class="btn btn-primary" type="submit" name="Adicionar" value="Adicionar">
                    <?php 
                    if (isset($_POST["Adicionar"])) {
                        if (isset($_SESSION["userId"])) {
                            
                            $texto = $_POST["texto"];
                            $categoria = $_POST["categoria"];
                            $careta = "-.-'";

                            if (empty($texto)) {
                                echo '<script>swal("Oops!", "Escreve algo que queiras sugerir '.$careta.'", "error");</script>';
                                exit;
                            }

                            $sql="INSERT INTO sugestoes (Texto,Categoria,Vista) VALUES('$texto','$categoria',false)";
 
                            $db->query($sql);

                            echo '<script>swal("Sugestão!", "Obrigado pelo teu suporte", "success");</script>';
                        }
                        else{
                            header("Location: login.php");
                        }
                    }
                ?>
                </form>    
            </div>
            <?php include_once("includes/footer.php"); ?>
        </div>
    </div>
</body>
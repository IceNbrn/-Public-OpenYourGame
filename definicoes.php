<?php
ob_start();
session_start();


include_once ("includes/database.php");
include_once ("includes/classes.php");
$functions = new functions();
$db = new DatabaseIcen();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
$functions->isLoggedAndAdmin($_SESSION["userId"]);
if(isset($_GET["v"])){
    $v = $_GET['v'];
    $db->query("UPDATE definicoes SET manutencao = $v");
    header("Location: definicoes");
}
$pagina = 1;
if (isset($_GET["p"])) {
    if($_GET["p"] == 0){
        $pagina = 1;
    }else{
        $pagina = $db->quote($_GET["p"]);
    }
    
}
?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Denuncias</title>
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

</head>
<body>
<?php include_once("includes/menu.php"); 
$titulo = "Denuncias";
include_once("includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">

        <?php include_once("includes/menu_admin.php"); ?>

        <div class="row">
            <?php
            $db->getDefinicoes();
            ?>

        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
    <script>
        function manutencao(valor) {
            var txt = "";
            var txtbtn = "";
            if(valor == 1){
                txt = "Irá colocar o site em manutenção!";
                txtbtn = "Sim ir para manutenção!";
            }
            if(valor == 0){
                txt = "Irá retirar o site da manutenção!";
                txtbtn = "Retirar da manutenção";

            }
            swal({
                    title: "Tem a certeza?",
                    text: txt,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: txtbtn,
                    closeOnConfirm: false
                },
                function(){
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open('POST', 'definicoes?v=' + valor, true);

                    xmlhttp.send();
                    swal("Manutenção!", "O site agora está em manutenção.", "success");
                });
        }

    </script>
    <script src="js/sweetalert.min.js"></script>
</body>
</html>
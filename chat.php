<?php
ob_start();
session_start();
include_once ("includes/classes.php");
$functions = new functions();
$functions->isLogged($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);;
?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Chat Box</title>
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
include_once("includes/menu.php");
include_once("includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <h2>
            ChatBox
        </h2>

        <?php
        include_once("includes/database.php");
        $db = new DatabaseIcen();
        ?>

        <div class="row">
            <div id="show_">
                <div id="show" class="col-md-11 box" style="padding-top: 15px; word-wrap: break-word;"></div>

                <textarea name="msg" id="msg" class="text_show"></textarea>
                <input type="submit" name="send" id="send" value="Enviar" onclick="submitChat()" class="btn btn-primary btn-md btn-bd text_show">

            </div>
            <script type="text/javascript" src="js/chatbox.js"></script>
        </div>
        <?php include_once("includes/footer.php"); ?>
        <script>
            $("#msg").keyup(function(event){
                if(event.keyCode == 13){
                    $("#send").click();
                    document.getElementById('msg').value = "";
                }
            });
        </script>
    </div>

</body>
</html>

<!DOCTYPE html>
<?php
ob_start();
session_start();
if(isset($_SESSION["userId"])){
    header("Location: index");
}
?>
<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Login</title>
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
    <link rel="stylesheet" href="css/login.css">
    <script src="js/sweetalert.min.js"></script>
    <!-- INSERIR SCRIPT javascript -->



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

</head>
<body>

<?php
include("includes/menu.php");
?>
<div class="container">

    <form class="form-signin" method="post" action="login">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="oyg_input" placeholder="Username" name="username">
        <br>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" autocomplete="off" class="oyg_input" placeholder="Password" name="pass">
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <div class="col-md-6"><a href="registar" class="fac_login"><i>Não tem conta registre-se!</i></a></div>
        <div class="col-md-6"><a href="recuperarpassword" class="fac_login"><i>Recuperar Password!</i></a></div>
        <br>
        <input type="hidden" name="enviado" value="TRUE" /><p>
            <?php
            if(isset($_POST["enviado"])) {
                /*
                function ice_protect($var){
                    if(get_magic_quotes_gpc()){
                        $var = stripslashes($var);
                    }
                    return mysqli_real_escape_string($var);
                }*/


                include "includes/database.php";
                $db = new DatabaseIcen();
                $username = $db->quote($_POST['username']);//será que tem a ver com alguma coisa? é por causa do anti sql
                $password = sha1(md5($_POST['pass']));
                $db->login($username,$password);



            }

            ?>

    </form>
    <div style="margin-top: 40%"><?php include_once ("includes/footer.php");?></div>
</div> <!-- /container -->


</body>
</html>

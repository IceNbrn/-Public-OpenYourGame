<!DOCTYPE html>
<?php
ob_start();
//CASO A APRESENTAÇÃO SEJA LOCALHOST ISTO É false SE FOR ONLINE É true;
$APRESENTACAO = false;
//---------------------------------------------------------------------
?>
<?php
if(isset($_POST["enviado"])) {
    include "includes/database.php";
    include "includes/classes.php";
    $pass = null;
    $pass2 = null;
    $password = null;
    $password2 = null;

    $db = new DatabaseIcen();
    $functions = new functions();


    if(isset($_GET["secret"])){
        $secret = $db->quote($_GET["secret"]);
        $pass = $_POST["pass"];
        $pass2 = $_POST["confpass"];
        $password = sha1(md5($pass));
        $password2 = sha1(md5($pass2));
        if (empty($password) || empty($pass)) {
            echo '<script>swal("Oops!", "Por favor a password é inválida ou vazia!", "error");</script>';
            exit;
        } elseif (empty($password2) || empty($pass2)) {
            echo '<script>swal("Oops!", "Por favor a confirmação da password é vazia!", "error");</script>';
            exit;
        } elseif ($password != $password2) {
            echo '<script>swal("Oops!", "A confirmação da password está errada!", "error");</script>';
            exit;
        } elseif ($secret) {
            header("Location: error404");
        }
        $db->recuperaPassword($secret,$password);
    }


}

?>
<html lang="pt-pt">
  <head>
    <meta charset="utf-8">
    <title>OYG - Recuperar Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="icon" href="images/icon.png" type="image/x-icon" />
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <!-- INSERIR SCRIPT javascript -->



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

  </head>
  <body>

  <?php
  include("includes/menu.php");
  $titulo = "Recuperar Password";
  ?>
  <div class="container">

      <form class="form-signin" method="post" action="mudarpassword?secret=<?=$_GET["secret"]?>">
          <h2 class="form-signin-heading">Recuperar Password</h2>
            <h2 class="form-signin-heading">Digite a nova password</h2>
            <label for="pass" class="sr-only">Password</label>
            <input type="password" id="pass" class="oyg_input" placeholder="Password" name="pass">
            <br>
            <label for="confpass" class="sr-only">Confirmar Password</label>
            <input type="password" id="confpass" class="oyg_input" placeholder="Confirmar Password" name="confpass">
            <br>


          <input class="btn btn-lg btn-primary btn-block" id="enviado" name="enviado" value="Recuperar" type="submit">
          <br>
          <input type="hidden" name="enviado" value="TRUE" /><p>


      </form>
      <div style="margin-top: 40%"><?php include_once ("includes/footer.php");?></div>
  </div> <!-- /container -->


  </body>
</html>

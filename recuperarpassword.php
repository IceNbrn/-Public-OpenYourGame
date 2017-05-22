<!DOCTYPE html>
<?php
ob_start();
//CASO A APRESENTAÇÃO SEJA LOCALHOST ISTO É false SE FOR ONLINE É true;
$APRESENTACAO = false;
//---------------------------------------------------------------------
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
  if(isset($_POST["enviado"])) {
      include "includes/database.php";
      include "includes/classes.php";
      $email = null;
      $pass = null;
      $pass2 = null;
      $password = null;
      $password2 = null;

      $db = new DatabaseIcen();
      $functions = new functions();

      $email = $db->quote($_POST['email']);

      if(empty($email)){
          //echo '<span style="color:#FF0000;text-align:center;"> Por favor o email é inválido ou vazio!</span>';
          echo '<script>swal("Oops!", "Por favor o email é inválido ou vazio!", "error");</script>';

      }
      $detetar_arroba = strpos($email, "@");
      if (empty($email) || $detetar_arroba == false) {
          //echo '<span style="color:#FF0000;text-align:center;"> Por favor o email é inválido ou vazio!</span>';
          echo '<script>swal("Oops!", "Por favor o email é inválido ou vazio!", "error");</script>';

      }

      $users = $db->query("SELECT email FROM utilizadores WHERE email = '$email'");
      if($users->num_rows > 0){
          if($APRESENTACAO) {
              $functions->enviarEmail($email);
          }else {
              include_once ("includes/database.php");
              include_once ("includes/classes.php.php");
              $db = new DatabaseIcen();
              $functions = new functions();
              $secret = $functions->randomStringNow($email);
              $db->query("UPDATE utilizadores SET linkRecuperar = '{$secret}' WHERE email = '$email'");
              header("Location: http://openyourgame.xyz/enviarEmail?email=$email&secret=$secret");
          }
      }else{
          echo '<script>swal("Oops!", "Não existe nenhum nenhum email igual ou ocorreu um erro!", "error");</script>';
      }




  }

  ?>
  <?php
  include("includes/menu.php");
  $titulo = "Recuperar Password";
  ?>
  <div class="container">

      <form class="form-signin" method="post" action="recuperarpassword">
          <h2 class="form-signin-heading">Recuperar Password</h2>
            <label for="email" class="sr-only">Email</label>
                <input type="text" id="email" class="oyg_input" placeholder="Email" name="email">
          <br>
          <input class="btn btn-lg btn-primary btn-block" id="enviado" name="enviado" value="Recuperar" type="submit">
          <br>
          <input type="hidden" name="enviado" value="TRUE" /><p>


      </form>

      <div style="margin-top: 40%"><?php include_once ("includes/footer.php");?></div>
  </div> <!-- /container -->


  </body>
</html>

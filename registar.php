<?php
include_once ("includes/classes.php");
$functions = new functions();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null); ?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Registar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- INSERIR SCRIPT javascript -->




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body>
<?php
include_once("includes/menu.php");
$titulo = "Registar";
include_once("includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header">


        <div class="row">


            <form action="registar" method="post" style="align:center" class="form-register">
                <h2>Registar</h2>
                <!--Email--><input type="text" name="email" id="email" size=20 maxlenght="20" class="oyg_input" placeholder="Email" ><br><br>
                <!--Username--><input type="text" name="username" id="username" size=20 maxlenght="50" class="oyg_input" placeholder="Username"><br><br>
                <!--Password--><input type="password" name="password" id="password" size="20" maxlenght="10" class="oyg_input" placeholder="Password"><br><br>
                <!--ConfirmPass--><input type="password" name="confirmar" id="confirmar" size="20" maxlenght="10" class="oyg_input" placeholder="Confirmar Password"><br><br>
                <input type="hidden" name="upload" value="1">
                <br>
                <!--<input type="file" name="ficheiroUpload" id="ficheiroUpload" class="form-control">-->
                <br>
                <div class="g-recaptcha" data-sitekey="6Lf5SB0UAAAAAHkOJtdiQVxNbpeB_dsytgWssVlr"></div>
                <br>
                <div class="h_bar-btn">
                    <input type="submit" name="submit" value="Registar" class="btn btn-primary btn-md btn-bd">
                </div>
                <a href="login" class="fac_login"><i>Já tem conta faça login!</i></a
                <input type="hidden" name="enviado" value="TRUE" /><p>
                    <!--<a href="login.php" class="fac_login"><i>Já tem conta Faça Login</i></a>-->
                    <?php
                    include_once("includes/database.php");//Test
                    include_once("includes/classes.php");
                    $db = new DatabaseIcen();
                    $functions = new functions();
                    if(isset($_POST["submit"])) {
                        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                            //your site secret key
                            $secret = '6Lf5SB0UAAAAAARclFC17CfdGDZKqF9KWWfPdrUv';
                            //get verify response data
                            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                            $responseData = json_decode($verifyResponse);
                            if($responseData->success) {
                                $username = $db->quote($_POST["username"]);
                                $email = $db->quote($_POST["email"]);
                                $pass = $_POST["password"];
                                $pass2 = $_POST["confirmar"];
                                $password = sha1(md5($pass));
                                $password2 = sha1(md5($pass2));
                                $perfil = 1;//1 = membro
                                $id_utilizador = 0;
                                $eliminado = 0;//0 = false
                                $steamid = 0;
                                $detetar_arroba = strpos($email, "@");
                                $avatar_url = "images/avatars/default_avatar.jpg";
                                $dataRegisto = $functions->gethoraData();

                                if (empty($email) || $detetar_arroba == false) {
                                    //echo '<span style="color:#FF0000;text-align:center;"> Por favor o email é inválido ou vazio!</span>';
                                    echo '<script>swal("Oops!", "Por favor o email é inválido ou vazio!", "error");</script>';
                                    exit;
                                } elseif (empty($username)) {
                                    //echo '<span style="color:#FF0000;text-align:center;"> Por favor o nome é inválido ou vazio!</span>';
                                    echo '<script>swal("Oops!", "Por favor o username é inválido ou vazio!", "error");</script>';
                                    exit;
                                } elseif (empty($password) || empty($pass)) {
                                    //echo '<span style="color:#FF0000;text-align:center;"> Por favor o email é inválido ou vazio!</span>';
                                    echo '<script>swal("Oops!", "Por favor a password é inválida ou vazia!", "error");</script>';
                                    exit;
                                } elseif (empty($password2) || empty($pass2)) {
                                    //echo '<span style="color:#FF0000;text-align:center;"> Por favor o email é inválido ou vazio!</span>';
                                    echo '<script>swal("Oops!", "Por favor a confirmação da password é vazia!", "error");</script>';
                                    exit;
                                } elseif ($password != $password2) {
                                    echo '<script>swal("Oops!", "A confirmação da password está errada!", "error");</script>';
                                    exit;
                                }
                                $sql = "SELECT * FROM utilizadores WHERE username = {$username} OR email = {$email}";

                                if ($db->userEmailExists($email, $username) == 0) {
                                    $sql_insert = "INSERT INTO utilizadores (id_utilizador,username,password,email,avatar_url,dataRegisto,eliminado,perfil,steamId) VALUES($id_utilizador,'$username','$password','$email','$avatar_url','$dataRegisto',$eliminado,$perfil,'$steamid')";
                                    //$sql_insert="INSERT utilizadores VALUES('".$id_utilizador."','".$username."','".$password."','".$email."','".$avatar_url."','".$dataRegisto."','".$eliminado."','".$perfil."','".$steamid."')";
                                    $db->query($sql_insert);

                                    echo '<script>swal("Utilizador", "O utilizador foi registado com sucesso!", "success");</script>';

                                } else {
                                    echo '<script>swal("Oops!", "Já existe um utilizador com esse username ou email!", "error");</script>';
                                }
                            }else{
                                echo '<script>swal("Oops!", "O reCAPTCHA falhou! Tente de novo!", "error");</script>';
                            }

                        }else{
                            echo '<script>swal("Oops!", "Tem de fazer o reCAPTCHA!", "error");</script>';
                        }


                    }
                    ?>

            </form>

        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
    <script src="js/sweetalert.min.js"></script>
</div>
</body>
</html>

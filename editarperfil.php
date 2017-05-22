<?php
ob_start();
session_start();

include_once ("includes/classes.php");
$functions = new functions();
$user = null;
$id = null;
if(isset($_GET['id']) || isset($_SESSION["userId"])){
    require_once("includes/database.php");
    $db = new DatabaseIcen();
    $temJogo = null;
    if(isset($_GET['id'])){
        if($db->isAdmin($_SESSION["userId"]) == 1) {
            $user = $db->getName($db->quote($_GET['id']));
            if ($db->usernameExists($user) == 0) {
                header("Location: error404");
            }
            $id = $db->getId($user);
            $perfil = $db->getNivelPerfil($id);
            if($perfil > $db->getNivelPerfil($_SESSION["userId"])){
                header("Location: error404");
            }
        }else{
            header("Location: error404");
        }
    }
    else{
        $id = $_SESSION["userId"];
        $user = $db->getName($id);
    }
    $username = null;

    $sql = "SELECT * FROM utilizadores WHERE id_utilizador = $id";
    $resultado = $db->query($sql);

    if($resultado->num_rows > 0){
        while ($row = $resultado->fetch_assoc()) {
            $email = $row["email"];
            $username = $row["username"];
            $avatar_url = $row["avatar_url"];
            $perfil = $row["perfil"];
        }
    }

    $steamId = $db->userSteamLinked($id);



}
else{
    $functions->notLogged();
    if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
    else $functions->manutencao(null);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    <script src="js/sweetalert.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- INSERIR SCRIPT javascript -->




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body>
<?php
include_once("includes/menu.php");
$titulo = "Editar Perfil";
include_once("includes/banner.php");
?>
<div class="container containerSpace">
    <div class="page-header">


        <div class="row">


            <form enctype="multipart/form-data" <?php if(isset($_GET["id"])) echo "action='editarperfil?id=$id'"; elseif(isset($_SESSION["userId"])) echo "action='editarperfil'"; ?> method="post" style="align:center" class="form-register">
                <h2>Editar : <?=$db->getName($id)?></h2>
                <!--Email--><h4>Email:</h4><input type="text" name="email" id="email" size=20 maxlenght="20" class="oyg_input" placeholder="Email" value="<?=$email;?>"><br><br>
                <!--Username--><h4>Username:</h4><input type="text" name="username" id="username" size=20 maxlenght="50" class="oyg_input" placeholder="Username" value="<?=$username;?>"><br><br>
                <!--Password--><h4>Password:</h4><input type="password" name="password" id="password" size="20" maxlenght="10" class="oyg_input" placeholder="Password"><br><br>
                <!--ConfirmPass--><h4>Confirmar Password:</h4><input type="password" name="confirmar" id="confirmar" size="20" maxlenght="10" class="oyg_input" placeholder="Confirmar Password"><br><br>
                <!--Perfil-->
                <?php if($db->isAdmin($_SESSION["userId"])){?>
                    <h4>Perfil:</h4>
                    <div class="select">
                        <select name="perfil" id="perfil">
                            <?php
                            $functions->setSelected($db->getNivelPerfil($id));
                            ?>
                        </select>
                    </div>
                    <br><br>
                <?php }?>
                <img style="width: 35%" class="img-responsive" src='<?=$avatar_url?>' alt="">
                <br>
                <input type="file" name="upfile" id="upfile" class="form-control">
                <input type="hidden" name="upload" value="1">
                <br>
                <!--<input type="file" name="ficheiroUpload" id="ficheiroUpload" class="form-control">-->
                <br>
                <div class="g-recaptcha" data-sitekey="6Lf5SB0UAAAAAHkOJtdiQVxNbpeB_dsytgWssVlr"></div>
                <br>
                <input type="submit" name="submit" value="Guardar" class="btn btn-primary btn-md btn-bd">
                <input type="hidden" name="enviado" value="TRUE" /><p>
                    <!--<a href="login.php" class="fac_login"><i>Já tem conta Faça Login</i></a>-->
                    <?php
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
                                $perfil = $_POST["perfil"];
                                $pass = $_POST["password"];
                                $pass2 = $_POST["confirmar"];
                                $password = sha1(md5($pass));
                                $password2 = sha1(md5($pass2));
                                $id_utilizador = 0;
                                $eliminado = 0;//0 = false
                                $steamid = 0;
                                $detetar_arroba = strpos($email, "@");
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

                                try {

                                    // Undefined | Multiple Files | $_FILES Corruption Attack
                                    // If this request falls under any of them, treat it invalid.
                                    if (!isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error'])) {
                                        throw new RuntimeException('Invalid parameters.');
                                    }

                                    // Check $_FILES['upfile']['error'] value.
                                    switch ($_FILES['upfile']['error']) {
                                        case UPLOAD_ERR_OK:
                                            break;
                                        case UPLOAD_ERR_NO_FILE:
                                            throw new RuntimeException('No file sent.');
                                        case UPLOAD_ERR_INI_SIZE:
                                        case UPLOAD_ERR_FORM_SIZE:
                                            throw new RuntimeException('Exceeded filesize limit.');
                                        default:
                                            throw new RuntimeException('Unknown errors.');
                                    }

                                    // You should also check filesize here.
                                    if ($_FILES['upfile']['size'] > 1000000) {
                                        throw new RuntimeException('Exceeded filesize limit.');
                                    }

                                    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                                    // Check MIME Type by yourself.
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    if (false === $ext = array_search(
                                            $finfo->file($_FILES['upfile']['tmp_name']),
                                            array(
                                                'jpg' => 'image/jpeg',
                                                'png' => 'image/png',
                                                'gif' => 'image/gif',
                                            ),
                                            true
                                        )) {
                                        throw new RuntimeException('Invalid file format.');
                                    }
                                    $x = rand(1, 9999);
                                    // You should name it uniquely.
                                    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                                    // On this example, obtain safe unique name from its binary data.
                                    if (!move_uploaded_file(
                                        $_FILES['upfile']['tmp_name'],
                                        sprintf('images/avatars/%s.%s',
                                            $id_utilizador.$x.$_FILES['upfile']['error'],
                                            $ext
                                        )
                                    )) {
                                        throw new RuntimeException('Failed to move uploaded file.');
                                    }

                                    $sql = "SELECT * FROM utilizadores WHERE username = {$username} OR email = {$email}";
                                    $avatar_url = sprintf('images/avatars/%s.%s',
                                        $id_utilizador.$x.$_FILES['upfile']['error'],
                                        $ext
                                    );
                                    if ($db->userEmailExists($email, $username) == 1) {
                                        $sql_insert = "UPDATE utilizadores SET username = '$username', password = '$password', email = '$email', avatar_url = '$avatar_url', perfil = $perfil WHERE id_utilizador = $id";
                                        //$sql_insert="INSERT utilizadores VALUES('".$id_utilizador."','".$username."','".$password."','".$email."','".$avatar_url."','".$dataRegisto."','".$eliminado."','".$perfil."','".$steamid."')";
                                        //echo $sql_insert;
                                        echo '<script>swal("Update", "Perfil atualizado!", "success")</script>';
                                        $db->query($sql_insert);

                                    } else {
                                        echo '<script>swal("Oops!", "Já existe um utilizador com esse username ou email!", "error");</script>';
                                    }

                                } catch (RuntimeException $e) {

                                    echo $e->getMessage();

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

</div>
</body>
</html>

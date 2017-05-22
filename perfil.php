
<!DOCTYPE html>
<html lang="pt-pt">
<?php
ob_start();
session_start();

include_once ("includes/classes.php");
$functions = new functions();

if(isset($_GET['username']) || isset($_SESSION["userId"])){
    require_once("includes/database.php");
    $db = new DatabaseIcen();
    $temJogo = null;
    $statsSTATUS = null;
    if(isset($_GET['username'])){
        $user = $db->quote($_GET['username']);
        if($db->usernameExists($user) == 0){
            header("Location: error404");
        }
        $id = $db->getId($user);
    }
    else{
        $id = $_SESSION["userId"];
        $user = $db->getName($id);
    }

    $steamId = $db->userSteamLinked($id);
    if(isset($_POST["convidar"]) && isset($_GET["username"]) && isset($_SESSION["userId"])){
        $idUserLogado = $_SESSION["userId"];
        $idUserPerfil = $db->getId($_GET["username"]);
        if($idUserLogado != $idUserPerfil)
            $db->convidaJogador($idUserLogado,$idUserPerfil);
    }
    elseif(isset($_POST["verStats"])){

        $selectedIdJogo = $_POST["select_perfil"];
        if($selectedIdJogo == 730){
            if($db->steamConnection($id) == true) {
                if ($functions->userHaveGame($id, $selectedIdJogo, $steamId)) {
                    $db->updateStats($selectedIdJogo, $id, $steamId);
                    $temJogo = true;
                    $statsSTATUS = "Geral";
                } else {
                    $temJogo = false;
                }
            }
        }
        $NP = $db->getNP($id,$selectedIdJogo);
        $NR = $db->getNR($id,$selectedIdJogo);
    }elseif(isset($_POST["verStatsUJ"])){
        $selectedIdJogo = $_POST["select_perfil"];
        if($db->getEstatisticas($id,$selectedIdJogo)["lastmatch_bestweapon"] != "") {

            if ($selectedIdJogo == 730) {
                if ($db->steamConnection($id) == true) {
                    if ($functions->userHaveGame($id, $selectedIdJogo, $steamId)) {
                        $db->updateStats($selectedIdJogo, $id, $steamId);
                        $temJogo = true;
                        $statsSTATUS = "UltimoJogo";
                    } else {
                        $temJogo = false;
                    }
                }
            }
            $NP = $db->getNP($id, $selectedIdJogo);
            $NR = $db->getNR($id, $selectedIdJogo);
        }else{
            echo "<script>swal(\"Erro!\", \"O jogador não tem estatísticas a apresentar no ultimo jogo!\", \"error\");</script>";
        }
    }else{

        $selectedIdJogo = 0;
    }
    $selectedNomeJogo = $db->getGame($selectedIdJogo);
    $perfil= $db->getNivelPerfil($id);
    $perfilTexto = null;

    if($perfil == 1){
        $perfilTexto = "<h2 style='color: #00DFFC'>Membro</h2>";
    }
    if($perfil == 2){
        $perfilTexto = "<h2 style='color: #FF0000'>Admin</h2>";
    }
    if($perfil == 3){
        $perfilTexto = "<h2 style='color: #ffaa17'>Fundador</h2>";
    }

    //DEBUG: echo "<br><br>".$_POST["verStatsUJ"]. $_POST["verStats"]."<br>".$selectedNomeJogo.$selectedIdJogo.$temJogo;

}
else{
    $functions->notLogged();
    if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
    else $functions->manutencao(null);
}

?>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OYG - <?php echo $user; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">

    <script src="js/select.js"></script>


    <!-- INSERIR SCRIPT javascript -->


</head>

<body>

    <?php
    include_once("includes/menu.php");
    $titulo = "Perfil";
    include_once("includes/banner.php");
    ?>
    <div class="container-fluid containerSpace">
        <div class="page-header">


        <!-- Intro Content -->
        <div class="row">

                <div class="col-md-2 spacePls" style="padding-top: 15px;">

                    <img class="img-responsive" src='<?php echo $db->getAvatarURL($id); ?>' alt="">
                </div>

                <div class="col-md-6">
                    <?= $perfilTexto ?><h2><?= $user;?></h2>

                        <?php

                        if(isset($_SESSION["userId"]) && isset($_GET["username"])) {
                            $idUserLogado = $_SESSION["userId"];
                            $idUserPerfil = $db->getId($_GET["username"]);
                            if ($idUserPerfil != $idUserLogado) {
                                echo "
                                <div class='row'>
                                    <input onclick='denunciar()' class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"denunciar\" value=\"Denunciar\">
                                    <br>
                                ";
                                if($db->userConvidouUser($idUserLogado,$idUserPerfil) == false){
                                ?>
                                <form action="perfil?username=<?php echo $user?>" method="post">
                                    <br>
                                    <input class="btn btn-primary btn-lg" type="submit" name="convidar" value="convidar">

                                </form>
                                </div>

                                <?php
                                }else{
                                    echo "<a data-toggle=\"tooltip\" title=\"Só aparece porque o jogador aceitou o teu convite!\" href='{$db->getSteamProfileLink($id)}'>Steam Profile</a>";
                                }
                            }
                        }
                        ?>

                </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <br>
                <form action="perfil?username=<?php echo $user?>" method="post">
                    <div class="select">
                        <select name="select_perfil" id="perfil_select">
                            <?php

                            $sql = "SELECT * FROM jogos WHERE id_jogo <> -1";

                            $jogos = $db->query($sql);


                            if($jogos->num_rows >0){
                                while ($row = $jogos->fetch_assoc()){

                                    $nameOfGame = $row["nome"];
                                    $idJogo = $row["id_jogo"];
                                    echo "<option value=".$idJogo.">$nameOfGame</option>";
                                }
                            }
                            else{
                                echo "<option>Não existem jogos na base de dados!</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <input type="submit" name="verStats" value="Ver stats" style="background-color: #1b1b1b!important;" class="btn btn-lg">
                    <input type="submit" name="verStatsUJ" value="Ver stats do ultimo jogo" style="background-color: #1b1b1b!important;" class="btn btn-lg">
                </form>
            </div>
        </div>
        <br>

        <?php if($selectedIdJogo == 730 && $temJogo){ ?>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Stats</h2>
                <div class="progress"
                <?php
                if(isset($_SESSION["userId"]) && isset($_GET["username"])) {
                    $idUserLogado = $_SESSION["userId"];
                    $idUserPerfil = $db->getId($_GET["username"]);
                    if ($idUserPerfil != $idUserLogado) {
                        echo "onclick='avaliar(1)'";
                    }else{
                        echo "onclick='avaliar(0)'";
                    }

                }
                ?>>
                  <div data-toggle="tooltip" title="NP: Nível de Perícia (Clique para avaliar)" class="progress-bar progress-oyg-np-<?php echo round($NP); ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <?php
                    echo "NP: ".round($NP);
                    ?>
                  </div>
                </div>
                <div class="progress"
                <?php
                if(isset($_SESSION["userId"]) && isset($_GET["username"])) {
                    $idUserLogado = $_SESSION["userId"];
                    $idUserPerfil = $db->getId($_GET["username"]);
                    if ($idUserPerfil != $idUserLogado) {
                        echo "onclick='avaliar(2)'";
                    }else{
                        echo "onclick='avaliar(0)'";
                    }
                }
                ?>>
                    <div data-toggle="tooltip" title="NR: Nível de Reputação (Clique para avaliar)" class="progress-bar progress-oyg-np-<?php echo round($NR); ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <?php
                        echo "NR: ".round($NR);
                        ?>
                    </div>
                </div>
            </div>
            <?php  $lastmatch_weaponfav = $db->getEstatisticas($id,$selectedIdJogo)["lastmatch_bestweapon"];
            $lastmatch_weaponfav_kills = $db->getEstatisticas($id,$selectedIdJogo)["lastmatch_weapon_kills"];
            $lastmatch_kd = $db->getEstatisticas($id,$selectedIdJogo)["lastmatch_kd"];
            $lastmatch_mvp = $db->getEstatisticas($id,$selectedIdJogo)["lastmatch_mvp"];
            if($statsSTATUS == "UltimoJogo" && $statsSTATUS != "Geral"){
            ?>
            <div class="col-lg-12"><h3>Ultimo Jogo</h3></div>
            <div class="col-md-4 text-center">
                <div class="thumbnail">
                    <h3>Arma favorita</h3>


                    <img class="img-responsive" src="<?php $functions->imagemArma($lastmatch_weaponfav,$selectedIdJogo) ?>" alt="">
                    <div class="caption">

                        <h3><?php echo $lastmatch_weaponfav ?><br>

                          <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" title="<?php echo $lastmatch_weaponfav_kills ?> Kills">« <?php echo $lastmatch_weaponfav_kills ?> »</p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="thumbnail">
                    <h3>KD</h3>


                    <img class="img-responsive" src="images/KD.png" alt="">
                    <div class="caption">

                        <h3><?php echo $lastmatch_kd ?><br>

                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" title="Kills/Deaths">K/D</p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="thumbnail">
                    <h3>MVP's</h3>


                    <img class="img-responsive" src="images/MVP.png" alt="">
                    <div class="caption">

                        <h3><?php echo $lastmatch_mvp ?><br>

                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" title="MVP's da partida">MVP's</p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>
            <?php }elseif($statsSTATUS == "Geral"){ ?>
            <div class="col-lg-12"><h3>Geral</h3></div>
            <div class="col-md-3 text-center">
                <div class="thumbnail">
                    <h3>(%) Vitórias</h3>
                    <img class="img-responsive" src="images/VITORIAS.png" alt="">
                    <div class="caption">
                        <?php $percentagemVitorias = $db->getEstatisticas($id,$selectedIdJogo)["percentagemVitorias"]; ?>
                        <h3><?php echo $percentagemVitorias ?><br>
                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" > % </p>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="thumbnail">
                    <h3>Kills/Deaths</h3>
                    <img class="img-responsive" src="images/KD.png" alt="">
                    <div class="caption">
                        <?php $kd = $db->getEstatisticas($id,$selectedIdJogo)["kills_deaths"]; ?>
                        <h3><?php echo $kd ?><br>
                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" title="Kills/Deaths"> K/D </p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="thumbnail">
                    <h3>Tempo Jogado</h3>
                    <img class="img-responsive" src="images/TEMPOJOGADO.png" alt="">
                    <div class="caption">
                        <?php $tempoJogado = $db->getEstatisticas($id,$selectedIdJogo)["tempoJogado"]; ?>
                        <h3><?php echo $tempoJogado ?><br>
                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" > Horas </p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="thumbnail">
                    <h3>Mapa Mais Jogado</h3>
                    <?php $mapaMaisJogado = $db->getEstatisticas($id,$selectedIdJogo)["mapaMaisJogado"]; $mapaMaisJogadoWins = $db->getEstatisticas($id,730)["mapaMaisJogadoWins"];?>
                    <img class="img-responsive"  src="<?php $functions->imagemMapa($mapaMaisJogado,730) ?>" alt="">
                    <div class="caption">
                        <h3><?php echo $mapaMaisJogado ?><br>
                            <p style="font-size:20px;color:#ffa700;" data-toggle="tooltip" title="<?php echo $mapaMaisJogadoWins ?> rondas ganhas"> <?php echo $mapaMaisJogadoWins ?> </p>
                            <!--<small><p>O teu KD é bom!</p></small>-->
                        </h3>
                    </div>
                </div>
            </div>
            <?php }?>

            <!-- Button trigger modal -->








        </div>
        <?php
        }else{
            if($selectedIdJogo != 0){
                if($user == $db->getName(isset($_SESSION["userId"])))
                    echo "<script>swal('Erro', 'Não tens estatísticas a apresentar no jogo $selectedNomeJogo!', 'error');</script>";
                else
                    echo "<script>swal('Erro', 'O jogador $user não tem estatísticas a apresentar no jogo $selectedNomeJogo!', 'error');</script>";
            }

        }

        ?>
        <?php include_once("includes/footer.php"); ?>
        </div>
    </div>
    <script type="text/javascript">

        function avaliar(tipo){
            swal({
                    title: "Avaliar <?php echo $db->getName($id); ?>",
                    text: "Digite a sua avaliação:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Valor entre 0.0 entre 10.0"
                },
                function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("Tens de escrever o valor!");
                        return false;
                    }
                    if(isNaN(inputValue)){
                        swal.showInputError("Tem de ser um numero!");
                        return false;
                    }
                    if(parseInt(inputValue) >= 0 && parseInt(inputValue) <= 10) {



                        var xmlhttp = new XMLHttpRequest();
                        if(tipo == 0){
                            swal.showInputError("Não podes avaliar a ti mesmo!");
                        }
                        if(tipo == 1){
                            xmlhttp.open('POST', 'avaliar/avaliaPericia.php?v=' + inputValue + '&u=<?php echo $id . "&j=$selectedIdJogo"; ?>', true);
                        }
                        if(tipo == 2){
                            xmlhttp.open('POST', 'avaliar/avaliaReputacao.php?v=' + inputValue + '&u=<?php echo $id . "&j=$selectedIdJogo"; ?>', true);
                        }



                        xmlhttp.send();
                        swal("Bom trabalho!", "Avalias-te o jogador com " + inputValue, "success");
                    }else{
                        swal.showInputError("O número tem de ser entre 0-10");
                    }
                });
        }
        function denunciar(){
            swal({
                    title: "Denunciar <?php echo $db->getName($id); ?>",
                    text: "Denuncia:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Escreve a razão da denuncia"
                },
                function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("Tens de escrever a razão da denuncia!");
                        return false;
                    }

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open('POST', 'denunciar/denuncia.php?t=' + inputValue + '&u=<?php echo $id; ?>', true);

                    xmlhttp.send();
                    swal("Denuncia!", "Denuncias-te o jogador por: " + inputValue, "success");

                });
        }
    </script>
    <script src="js/sweetalert.min.js"></script>
</body>
</html>

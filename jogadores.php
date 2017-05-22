<?php
ob_start();
session_start();
include_once ("includes/classes.php");
$functions = new functions();
$functions->isLogged($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
include_once ("includes/database.php");
$db = new DatabaseIcen();
if(isset($_GET["jogo"])){
    if(!$db->jogoExist($_GET["jogo"]))
        header("Location: index");
    $pagina = 1;
    $sql = null;
    $pesquisa = null;
    $nomeJogador = null;
    $kd = null;
    $mapaMaisJogado = null;
    $nivelPericia = null;
    $nivelpericiaoperador = null;
    $nivelReputacao = null;
    $nivelreputacaoperador = null;
    $idJogo = $db->getGamesIDWithNome($db->quote($_GET["jogo"]));
    if (isset($_GET["p"])) {
        if($_GET["p"] == 0){
            $pagina = 1;
        }else{
            $pagina = $db->quote($_GET["p"]);
        }

    }else{
        $pagina = 1;
    }
    if(isset($_POST["ir_lista"]) && isset($_SESSION["userId"])){
        $idUserLogado = $_SESSION["userId"];
        $db->irListaJogadoresDisponiveis($idUserLogado,$idJogo);
    }
    if(isset($_POST["sair_lista"]) && isset($_SESSION["userId"])){
        $idUserLogado = $_SESSION["userId"];
        $db->sairListaJogadoresDisponiveis($idUserLogado,$idJogo);
    }
    if(isset($_POST["Pesquisar"]) && isset($_SESSION["userId"])){
        $niveis = array(1,2,3,4,5,6,7,8,9,10);
        $operadores = array("<=","=",">=");


        $nomeJogador = $db->quote($_POST["nome_jogador"]);
        $kd = $db->quote($_POST["kd"]);
        $mapaMaisJogado = $db->quote($_POST["mapaMaisJogado"]);
        $perVitorias = $db->quote($_POST["perVitorias"]);
        $nivelPericia = $db->quote($_POST["nivelpericia"]);
        $nivelpericiaoperador = $db->quote($_POST["nivelpericiaoperador"]);
        $nivelReputacao = $db->quote($_POST["nivelreputacao"]);
        $nivelreputacaoperador = $db->quote($_POST["nivelreputacaoperador"]);

        if(!empty($mapaMaisJogado) && substr($mapaMaisJogado, 0, 2) != 'de')
            $mapaMaisJogado = "de_".$mapaMaisJogado;
        foreach ($niveis as $valor){
            if($nivelPericia != $valor || $nivelReputacao != $valor)
                $pesquisa = false;
            else
                $pesquisa = true;
        }
        foreach ($operadores as $valor){
            if($nivelpericiaoperador != $valor || $nivelreputacaoperador != $valor)
                $pesquisa = false;
            else
                $pesquisa = true;
        }
        if($pesquisa){
            $sql = "
            SELECT utilizadores.username,utilizadores.avatar_url FROM utilizadores,estatisticas,avaliacoes 
            WHERE utilizadores.id_jogo = $idJogo 
                AND estatisticas.id_utilizador = utilizadores.id_utilizador 
                AND utilizadores.id_utilizador = avaliacoes.id_utilizador";
            if($nomeJogador != null)
                $sql .= " AND utilizadores.username = '{$nomeJogador}'";
            if($nivelPericia != null)
                $sql .= " AND avaliacoes.nivelPericia $nivelpericiaoperador {$nivelPericia}";
            if($nivelReputacao != null)
                $sql .= " AND avaliacoes.nivelReputacao $nivelreputacaoperador {$nivelReputacao}";
            if($kd != null)
                $sql .= " AND estatisticas.kills_deaths = '{$kd}'";
            if($mapaMaisJogado != null)
                $sql .= " AND estatisticas.mapaMaisJogado = '{$mapaMaisJogado}'";
            if($perVitorias != null)
                $sql .= " AND estatisticas.percentagemVitorias = '{$perVitorias}'";
        }




    }

}
else{
    header("Location: index");
}
?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Jogadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="images/icon.png" type="image/x-icon" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/jogadores.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body>
<?php
include_once("includes/menu.php");
$titulo = "Jogadores Disponívies";
include_once("includes/banner.php");
?>


<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <h1 style="color: orange"><?php echo $db->quote($_GET["jogo"])?></h1>
        <!--<h2 style="color: green">Jogadores Disponíveis</h2>-->
        <h2>Pesquisar</h2>
        <form action="jogadores?jogo=<?php echo $db->quote($_GET["jogo"]) ?>" method="post">
            <div>
                <div class="row">
                    <div class="col-md-3">
                        <p>Nome do jogador</p>
                        <input type="text" id="nome_jogador" class="oyg_input" placeholder="Nome do jogador" name="nome_jogador">
                    </div>
                    <div class="col-md-1">
                        <p>KD</p>
                        <input type="text" id="kd" class="oyg_input" placeholder="KD" name="kd">
                    </div>
                    <div class="col-md-2">
                        <p>Mapa mais Jogado</p>
                        <input type="text" id="mapaMaisJogado" class="oyg_input" placeholder="Mapa mais Jogado" name="mapaMaisJogado">
                    </div>
                    <div class="col-md-2">
                        <p>Percentagem de Vitórias</p>
                        <input type="text" id="perVitorias" class="oyg_input" placeholder="Percentagem de Vitórias" name="perVitorias">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <p>Nivel Pericia</p>
                        <div class="select">
                            <select name="nivelpericiaoperador" id="nivelpericiaoperador">
                                <option value=">=">Maior ou Igual</option>
                                <option value="=">Igual</option>
                                <option value="<=">Menor ou Igual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p>Nivel Pericia</p>
                        <div class="select">
                            <select name="nivelpericia" id="nivelpericia">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p>Nivel Reputação</p>
                        <div class="select">
                            <select name="nivelreputacaoperador" id="nivelreputacaoperador">
                                <option value=">=">Maior ou Igual</option>
                                <option value="=">Igual</option>
                                <option value="<=">Menor ou Igual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p>Nivel Reputação</p>
                        <div class="select">
                            <select name="nivelreputacao" id="nivelreputacao">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <input class="btn btn-primary btn-lg" type="submit" name="Pesquisar" value="Pesquisar">


            </div>
        </form>
    </div>
    <br>
    <form action="jogadores?jogo=<?php echo $db->quote($_GET["jogo"]) ?>" method="post">
        <input class="btn btn-primary btn-lg" type="submit" name="ir_lista" value="Ir para a lista de espera">
        <input class="btn btn-primary btn-lg" type="submit" name="sair_lista" value="Sair">
    </form>


    <?php
    include_once("includes/database.php");
    $db = new DatabaseIcen();


    ?>
    <div class="row">
        <?php
        if($pesquisa)
            $db->getUsersToPlay($pagina,$idJogo,$nomeJogador,$kd,$mapaMaisJogado,$perVitorias,$nivelPericia,$nivelpericiaoperador,$nivelReputacao,$nivelreputacaoperador);
        else
            $db->getUsersToPlay($pagina,$idJogo);
        ?>
    </div>
    <div class="row">
        <div class="row">
            <?php
            $numToShow = 20;
            $sql1 = "SELECT * FROM utilizadores";

            if(!$pesquisa)
                $utilizadores = $db->query($sql1);
            else
                $utilizadores = $db->query($sql);

            $total_records = $utilizadores->num_rows;
            $total_pages = ceil($total_records / $numToShow);
            echo "<ul class='pager'>";
            $paginaTraz = $pagina - 1;
            $paginaFrente = $pagina + 1;
            echo "<li class='previous_'> <a href='jogadores?jogo={$_GET["jogo"]}&p={$paginaTraz}'><span aria-hidden='true'>&larr;</span>Anterior</a> </li>";
            for ($i=1; $i<=$total_pages; $i++) {
                echo "
                    
                  <li class='next_'><a href='jogadores?jogo={$_GET["jogo"]}&p=".$i."'><span aria-hidden='true'></span>$i</a></li>

                ";

            };
            echo "<li class='next_'> <a href='jogadores?jogo={$_GET["jogo"]}&p={$paginaFrente}'><span aria-hidden='true'>&rarr;</span>Proxima</a> </li></ul>";
            ?>
        </div>
    </div>
    <?php include_once("includes/footer.php"); ?>
</div>

</body>
</html>

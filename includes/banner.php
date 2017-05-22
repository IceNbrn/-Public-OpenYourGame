<style>
    .banner {
        height: 200px;
        width: 100%;
        max-height: 50%;
        max-width: 100%;
        min-height: 20%;
        min-width: 30%;
        text-shadow:
                -1px -1px 0 #2a2a2a,
                1px -1px 0 #343434,
                -1px 1px 0 #2a2a2a,
                1px 1px 0 #343434;
        background-image: url(
        <?php
        /*$jogo = null;
        $nomeFicheiro = basename($_SERVER["PHP_SELF"]);
        $nomeForum = str_replace("/".$nomeFicheiro,"",str_replace("/OpenYourGame/","",$_SERVER["PHP_SELF"]));
        if($nomeForum == "forum"){
            if($nomeFicheiro == "forum.php"){
                if(isset($_GET["jogo"]) == "CS:GO"){
                    $jogo = "CS:GO FORUM";
                    echo "https://a.thumbs.redditmedia.com/GPpEqgZwR8vCFfJz9L9DSBfBRi7oDWrKiHJ_vVgVlG4.png";
                }else{
                    $jogo = "nullFORUM";
                    echo "../images/bannerMontage.png";
                } 
            }elseif($nomeFicheiro == "index.php"){
                $jogo = "INDEX FORUM";
                echo "../images/bannerMontage.png";
            }else{
                echo "../images/banner.png";
            }
        }elseif($nomeFicheiro == "jogadores.php"){
            $jogo = "CS:GO JOGADORES";
            echo "images/banner.png";
        }elseif($nomeFicheiro == "perfil.php"){
            $jogo = "PERFIL";
            echo "images/bannerMontage.png";
        }else{
            $jogo = "null";
            echo "images/banner.png";
        }*/
        if (!isset($titulo)) {
            $titulo="";
        }
        if($titulo == "A Wikipedia do CS:GO"){
            echo "https://a.thumbs.redditmedia.com/GPpEqgZwR8vCFfJz9L9DSBfBRi7oDWrKiHJ_vVgVlG4.png";
        }elseif($titulo == "Topicos"){
            echo "../images/bannerMontage.png";
        }elseif($titulo == "Foruns"){
            echo "../images/bannerMontage.png";
        }elseif($titulo == "CS:GO - Forum"){
            echo "../images/bannerMontage.png";
        }elseif($titulo == "CS:GO - Forum"){
            echo "../images/banner.png";
        }else{
            echo "images/banner.png";
        }
        ?>);
        background-size: cover;
    }
</style>
<div class="jumbotron banner">
    <div class="container">
        <?php /*if($jogo == "CS:GO FORUM"){
            echo "
        <h2 style='text-align: center; margin-top: 5%; margin-bottom: 5%;opacity: 1 !important;'>
            A wikipédia do CS:GO
        </h2>";
        }else{
            if(!isset($titulo))
                $titulo = "";
            */echo "
        <h2 style='text-align: center; margin-top: 5%; margin-bottom: 5%'>
             $titulo
        </h2>";/*}*/ ?>
    </div>
</div>
<?php
ob_start();
session_start();

include_once ("includes/database.php");
include_once ("includes/classes.php");
$db = new DatabaseIcen();
$functions = new functions();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);

if($functions->isLogged($_SESSION["userId"]) == true){
    if($db->userSteamLinked($_SESSION["userId"]) == 0){
        require("includes/openid.php");
        $api = "API KEY WHERE"; //QD TIVER PUBLICO NO GITHUB TIRAR ISTO!
        $steamLinked = "Desligada";

        $OpenId = new LightOpenID("localhost");//MUDAR PARA http://openyourgame.xyz/

        if(!$OpenId->mode){
            if(!isset($T25SteamAuth)){
                $OpenId->identity = "http://steamcommunity.com/openid";
                header("Location: {$OpenId->authUrl()}");
            }
        }elseif($OpenId->mode == "cancel"){
            echo "O utilizador cancelou a autenticação!";
        }else{
            if(!isset($T25SteamAuth)){
                $T25SteamAuth = $OpenId->validate() ? $OpenId->identity : null;
                $T25SteamID64 = str_replace("http://steamcommunity.com/openid/id","", $T25SteamAuth);

                if($T25SteamAuth !== null){
                    $Steam64 = str_replace("http://steamcommunity.com/openid/id/","",$T25SteamAuth);
                    $profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$api}&steamids={$Steam64}");
                    $buffer = fopen("cache/{$Steam64}.json","w+");
                    fwrite($buffer,$profile);
                    fclose($buffer);
                    $steam = json_decode(file_get_contents("cache/{$T25SteamID64}.json"));
                }
                $cookie_name = "sucesso";
                setcookie($cookie_name, $cookie_name, time() + 86400, "/"); // 86400 = 1 day
                header("Location: index.php");


            }
        }


        if(!empty($steam->response->players[0]->steamid)){

            //»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»
            //VERIFICAR SE ALGÚEM JÁ TEM UMA CONTA COM O MESMO ID
            include_once ("includes/database.php");
            $db = new DatabaseIcen();
            if($db->steamIdExists($steam->response->players[0]->steamid) != 1){
                $sql = "UPDATE utilizadores SET steamId={$steam->response->players[0]->steamid},steamProfileLink='{$steam->response->players[0]->profileurl}' WHERE id_utilizador={$_SESSION['userId']}";
                $db->query($sql);
                unlink("cache/{$Steam64}.json");
            }
            //»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»»
        }
        unlink("cache/{$Steam64}.json");

    }else{
        header("Location: index.php");
    }
}



?>


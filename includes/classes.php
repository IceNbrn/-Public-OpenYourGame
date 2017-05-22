<?php

/**
 *
 */
class functions
{
    public function alert($type,$text,$title){
        echo "<script>swal('$title', '$text', '$type')</script>";
    }

    public function notAdmin()
    {
        header("Location: login");
    }

    public function notLogged()
    {
        header("Location: login");
    }

    public function uploadFile($imagem)
    {

    }

    function ice_protect($var)
    {
        if (get_magic_quotes_gpc()) {
            $var = stripslashes($var);
        }
        return mysqli_real_escape_string($var);
    }

    public function gethoraData()
    {
        $hora = date('H'); //depende se esta em LOCAL HOST OU NUM SERVIDOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        return date("d-m-Y") . " " . $hora . date(":i");

    }

    public function getData()
    {
        $hora = date('H'); //depende se esta em LOCAL HOST OU NUM SERVIDOR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        return date("Y-m-d");

    }

    public function chatFormat($data, $username, $text)
    {
        echo "[<a id='data_chat'>$data</a>] <a href='perfil?user=$username'>$username</a>: $text <br>";
    }

    public function isLoggedAndAdmin($userID)
    {
        include_once("database.php");
        $db = new DatabaseIcen();
        if (!isset($userID) || $db->isAdmin($userID) == 0) {
            $this->notLogged();
        }
    }

    public function isLogged($user)
    {
        if (!isset($user)) {
            $this->notLogged();
            return false;
        }
        return true;
    }

    public function convertSecondsToHour($seconds)
    {
        return round($seconds / 3600);
    }

    public function percentagemVitorias($wins, $totalwins)
    {
        return round((($wins / $totalwins) * 100), 1);
    }

    public function calcularKD($kills, $deaths)
    {
        $kd =  $kills != 0 ? round(($kills/$deaths),2) : 0;
        return $kd;
    }

    public function getWeapon($id)
    {
        $ficheiro = file_get_contents("csgo_weapons_ids.json");
        $buffer = fopen("csgo_weapons_ids.json", "w+");
        fwrite($buffer, $ficheiro);
        fclose($buffer);
        $csgo_weapons = json_decode(file_get_contents("csgo_weapons_ids.json"));

        $numeroweapons = count($csgo_weapons->weaponids->weapons);

        for ($i = 0; $i <= $numeroweapons; $i++) {
            if (isset($csgo_weapons->weaponids->weapons[$i]->id) && isset($csgo_weapons->weaponids->weapons[$i]->name)) {
                if ($csgo_weapons->weaponids->weapons[$i]->id == $id) {
                    return $csgo_weapons->weaponids->weapons[$i]->name;
                }

            }

        }
    }

    //Função para saber se o utilizador tem um jogo na conta steam
    public function userHaveGame($idUser, $idJogoSteam, $steamid)
    {
        $api = "API KEY WHERE";
        $var = "{$idUser}_games_";
        $url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key={$api}&steamid={$steamid}&format=json";
        if($this->steamIsUp($url)) {
            $profile = file_get_contents($url);
            $buffer = fopen("cache/{$var}{$steamid}.json", "w+");
            fwrite($buffer, $profile);
            fclose($buffer);
            $steam = json_decode(file_get_contents("cache/{$var}{$steamid}.json"));
            $numeroJogos = $steam->response->game_count;
            for ($i = 1; $i <= $numeroJogos; $i++) {
                if (isset($steam->response->games[$i]->appid) && isset($steam->response->games[$i]->playtime_forever)) {
                    if ($steam->response->games[$i]->appid == $idJogoSteam && $steam->response->games[$i]->playtime_forever != 0) {
                        unlink("cache/{$var}{$steamid}.json");
                        return true;
                    }

                }

            }
            unlink("cache/{$var}{$steamid}.json");//TODO: Colocar o unlink no steam connect (steam.php)
            return false;
        }
        return false;

    }

    //Função para saber o mapa mais jogado pelo o jogador
    public function getMapaMaisJogado($idUser, $id_jogo, $steamid)
    {

        $api = "API KEY WHERE";
        $var = "{$idUser}_mapa_{$id_jogo}_";
        $profile = file_get_contents("http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid={$id_jogo}&key={$api}&steamid={$steamid}");
        $buffer = fopen("cache/{$var}{$steamid}.json", "w+");
        fwrite($buffer, $profile);
        fclose($buffer);
        $steam = json_decode(file_get_contents("cache/{$var}{$steamid}.json"));

        //Rondas ganhas em cada mapa
        $cbble = $steam->playerstats->stats[30]->value;
        $dust2 = $steam->playerstats->stats[31]->value;
        $inferno = $steam->playerstats->stats[33]->value;
        $nuke = $steam->playerstats->stats[34]->value;
        $train = $steam->playerstats->stats[35]->value;

        $rondasMax = max($cbble, $dust2, $inferno, $nuke, $train);
        for ($i = 30; $i <= 35; $i++) {
            if (isset($steam->playerstats->stats[$i]->value) && isset($steam->playerstats->stats[$i]->name)) {
                if ($steam->playerstats->stats[$i]->value == $rondasMax) {
                    unlink("cache/{$var}{$steamid}.json");
                    return strtoupper(str_replace("total_wins_map_", "", $steam->playerstats->stats[$i]->name));
                }

            }

        }
        unlink("cache/{$var}{$steamid}.json");
    }
    //Retorna as vitorias do mapa com mais vitorias do jogador
    public function getMapaMaisJogadoWins($idUser, $id_jogo, $steamid)
    {

        $api = "API KEY WHERE";
        $var = "{$idUser}_mapa_{$id_jogo}_";
        $profile = file_get_contents("http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid={$id_jogo}&key={$api}&steamid={$steamid}");
        $buffer = fopen("cache/{$var}{$steamid}.json", "w+");
        fwrite($buffer, $profile);
        fclose($buffer);
        $steam = json_decode(file_get_contents("cache/{$var}{$steamid}.json"));

        //Rondas ganhas em cada mapa
        $cbble = $steam->playerstats->stats[30]->value;
        $dust2 = $steam->playerstats->stats[31]->value;
        $inferno = $steam->playerstats->stats[33]->value;
        $nuke = $steam->playerstats->stats[34]->value;
        $train = $steam->playerstats->stats[35]->value;

        $rondasMax = max($cbble, $dust2, $inferno, $nuke, $train);
        return $rondasMax;
    }

    public function steamIsUp($domain)
    {

//check, if a valid url is provided
        if(!filter_var($domain, FILTER_VALIDATE_URL))
        {
            return false;
        }

        //initialize curl
        $curlInit = curl_init($domain);
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        //get answer
        $response = curl_exec($curlInit);

        curl_close($curlInit);

        if ($response) return true;

        return false;


    }

    public function imagemMapa($nome, $idjogo)
    {
        $nome = strtolower($nome);
        echo "images/$idjogo/mapas/$nome.jpg";
    }

    public function imagemArma($nome, $idjogo)
    {
        $nome = strtolower($nome);
        $caminho = "images/$idjogo/armas/$nome.jpg";
        if(file_exists($caminho)){
            echo $caminho;
            return;
        }
        echo "images/null.png";
    }

    public function manutencao($user)
    {
        include_once("database.php");
        $db = new DatabaseIcen();
        if($user != null){
            if ($db->siteManutencao() == 1 && $db->isAdmin($user) == 0){
                session_start();
                session_unset();
                session_destroy();
                header("Location: manutencao.html");
                //return;
            }


        }else{
            if ($db->siteManutencao() == 1){
                header("Location: manutencao.html");
                //return;
            }
        }

    }
    function randomString($length, $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_?/{()*-+.><»«%#") {
        $string = "";
        $charsLength = strlen($chars);
        for ($i = 0; $i < intval($length); $i++) {
            $string .= $chars[rand(0, $charsLength - 1)];
        }
        return $string;
    }
    public function randomStringNow($email){
        return sha1($this->randomString(100).$this->randomString(25,$email).rand(0,9999));
    }
    public function enviarEmail($email,$apresentacao,$secret,$texto = "Recuperação da conta OpenYourGame"){


        date_default_timezone_set('Etc/UTC');

        require 'enviarEmails/PHPMailerAutoload.php';

        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        $mail->CharSet = 'UTF-8';

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "EMAIL";

        //Password to use for SMTP authentication
        $mail->Password = "EMAIL PASSWORD";

        //Set who the message is to be sent from
        $mail->setFrom('EMAIL FROM', 'OYG');

        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($email, $texto);

        //Set the subject line
        $mail->Subject = 'OpenYourGame recuperação da password';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML("<html>Para recuperar a password <a href='www.openyourgame.xyz/mudarpassword?secret={$secret}'>clica aqui</a></html>");
        if(!$apresentacao){
            $mail->msgHTML("<html>Para recuperar a password <a href='localhost/OpenYourGame/mudarpassword?secret={$secret}'>clica aqui</a></html>");
        }

        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
        //$mail->addAttachment('images/default_avatar.jpg');

        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
    public function setSelected($perfil){
        switch ($perfil){
            case 1:
                echo "                       
                    <option selected='selected' value='1'>Membro</option>
                    <option value='2'>Admin</option>
                    <option value='3'>Fundador</option>";
                break;
            case 2:
                echo "                       
                    <option value='1'>Membro</option>
                    <option selected='selected' value='2'>Admin</option>
                    <option value='3'>Fundador</option>";
                break;
            case 3:
                echo "
                    <option value='1'>Membro</option>
                    <option value='2'>Admin</option>
                    <option selected='selected' value='3'>Fundador</option>";
                break;
        }
    }
}


?>
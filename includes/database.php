<?php
class DatabaseIcen {
    // The database connection
    protected static $connection;

    /**
     * Connect to the database
     * 
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public function connect() {    
        // Try and connect to the database
        if(!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
            $config = parse_ini_file('config.ini'); 
            self::$connection = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);
            self::$connection->query('SET NAMES utf8');
        }

        // If connection was not successful, handle the error
        if(self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }

        return self::$connection;
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query) {
        // Connect to the database
        $connection = $this -> connect();

        // Query the database
        $result = $connection -> query($query);

        return $result;
    }

    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public function select($query) {
        $rows = array();
        $result = $this -> query($query);
        if($result === false) {
            return false;
        }
        while ($row = $result -> fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Fetch the last error from the database
     * 
     * @return string Database error message
     */
    public function error() {
        $connection = $this -> connect();
        return $connection -> error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value) {
        $connection = $this -> connect();
        return $connection -> real_escape_string($value); 
    }

    //-------------------------------NÃO ESTÁ A FUNCIONAR------------------------
    public 	function getIdUserLogado(){
    	$connection = $this -> connect();
		$username = $_SESSION["username"];

		$sql = "SELECT id FROM users WHERE username = '".$username."'";

		$resultado = $connection->query($sql);

		if($resultado->num_rows > 0){
			while ($row = $resultado->fetch_assoc()) {
				return $row["id"];
			}
		}
		return 0;
	}
    //-------------------------------NÃO ESTÁ A FUNCIONAR------------------------
	public function userSteamLinked($idUser){
		$connection = $this -> connect();
		$sql = "SELECT steamId FROM utilizadores WHERE id_utilizador = $idUser";
		$result = $connection->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		        return $row["steamId"];
		    }
		}
		return 0;

	}


	public function siteManutencao(){
		$connection = $this -> connect();
		$sql = "SELECT manutencao FROM definicoes WHERE id=1";

		$result = $connection->query($sql);

		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				return $row["manutencao"];
			}
		}
		return 0;

	}


    public function getGame($id){
        $connection = $this -> connect();
        $sql = "SELECT * FROM jogos WHERE id_jogo = $id";

        $result = $connection->query($sql);

        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                return $row["nome"];
            }
            return "<-no game->";
        }
    }

    public function getEstatisticas($iduser,$id_jogo){
        $connection = $this -> connect();
        $sql = "SELECT * FROM estatisticas WHERE id_jogo = $id_jogo AND id_utilizador = $iduser";
        $estatisticas = $connection->query($sql);

        if($estatisticas->num_rows > 0){
            while ($row = $estatisticas->fetch_assoc()) {
                return $row;
            }
        }else{
            return 0;
        }
    }
    public function getNP($id,$idjogo){
        $connection = $this -> connect();
        $sql = "SELECT nivelPericia FROM avaliacoes WHERE id_utilizador = $id AND id_jogo = $idjogo";

        $result = $connection->query($sql);

        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                return $row["nivelPericia"];
            }
        }else{
            return 0;
        }
    }

    public function getNR($id,$idjogo){
        $connection = $this -> connect();
        $sql = "SELECT nivelReputacao FROM avaliacoes WHERE id_utilizador = $id AND id_jogo = $idjogo";

        $result = $connection->query($sql);

        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                return $row["nivelReputacao"];
            }
        }else{
            return 0;
        }
    }

    public function getId($username){
        $connection = $this -> connect();
        $sql = "SELECT id_utilizador FROM utilizadores WHERE username = '$username'";

        $result = $connection->query($sql);

        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                return $row['id_utilizador'];
            }
        }
        else{
            return 0;
        }
    }

    public function isAdmin($id){
        $connection  = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE perfil >= 2 AND id_utilizador = $id";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            return 1;
        }
        return 0;
    }

    public function userEmailExists($email,$username){
        $connection  = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE username = '$username 'OR email = '$email'";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            return 1;
        }
    }


    public function usernameExists($username){

        if(isset($username)){
            $sql = "SELECT * FROM utilizadores WHERE username = '$username'";
        }
        $connection = $this->connect();
        //$sql = "SELECT * FROM Utilizadores WHERE id_utilizador ='".$id."'";

        $user = $connection->query($sql);
        if($user->num_rows > 0){
            return 1;
        }
    }
    public function steamIdExists($steamId){

        $sql = "SELECT steamId FROM utilizadores WHERE steamId ='".$steamId."'";

        $connection = $this->connect();

        $user = $connection->query($sql);
        if($user->num_rows > 0){
            return 1;
        }
    }
    public function getName($id_user){
        $connection = $this->connect();
        $sql = "SELECT username FROM utilizadores WHERE id_utilizador = {$id_user}";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                return $row["username"];
            }
        }
    }

    public function getAvatarURL($id){
        $connection = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE id_utilizador = $id";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                return $row["avatar_url"];
            }
        }
    }

    public function getNivelPerfil($id){
        $connection = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE id_utilizador = $id";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                return $row["perfil"];
            }
        }
        return -1;
    }
    public function login($username,$password){

        $connection = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE username = '".$username."' and password = '".$password."'";

        $user = $connection->query($sql);
        if($user->num_rows > 0){
            $userData= $user->fetch_array();
            $id = $userData["id_utilizador"];
            $eliminado = $userData["eliminado"];
            if($eliminado == 0){
                session_start();
                $_SESSION['userId'] = $id;

                //echo "<script>alert('Bem vindo ao painel $username');</script>";
                header("Location: index");
            }else{
                //echo "A tua conta está desativada!";
                echo "<script>swal('Oops!', 'A conta foi eliminada!', 'error');</script>";
            }

        }else{
            echo "<script>swal('Erro!', 'O username ou a password estão incorretos ou não existem!', 'error');</script>";
        }
    }
    public function recuperaPassword($secrect,$password){
        $connection = $this->connect();
        $sql = "SELECT * FROM utilizadores WHERE linkRecuperar = '$secrect'";

        $user = $connection->query($sql);
        if($user->num_rows > 0){
            $userData= $user->fetch_array();
            $id = $userData["id_utilizador"];
            $eliminado = $userData["eliminado"];
            $sql1 = "UPDATE utilizadores SET password = '{$password}' WHERE id_utilizador = $id";
            $connection->query($sql1);
            $sql2 = "UPDATE utilizadores SET linkRecuperar = '' WHERE id_utilizador = $id";
            $connection->query($sql2);
            header("Location: index");
        }else{
            echo "<script>swal('Oops!', 'Erro!', 'error');</script>";
        }
    }
    public function getUsers($idLogado,$pagina){
        $connection  = $this->connect();
        $sql = "SELECT * FROM utilizadores";

        $utilizadores = $connection->query($sql);

        if($utilizadores->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Data de Registo</th>
                            <th>Eliminado</th>
                            <th>Perfil</th>
                            <th>Steam Id</th>
                            <th>Opções</th>
                        </tr>
            ';
            while ($row = $utilizadores->fetch_assoc()){
                $userID = $row["id_utilizador"];
                $username = $row["username"];
                $email = $row["email"];
                $dataRegisto = $row["dataRegisto"];
                $eliminado = $row["eliminado"];
                $perfil = $row["perfil"];
                $steamId = $row["steamId"];
                if($this->getNivelPerfil($idLogado) < $perfil)
                    echo "

                        <tr style='color: #2a2828; background-color: #fcffb3;'>
                            <th><a href='perfil?username=$username'>$username</a></th>
                            <th>$email</th>
                            <th>$dataRegisto</th>
                            <th>$eliminado</th>
                            <th>$perfil</th>
                            <th>$steamId</th>
                            <th><a><span disabled class='glyphicon glyphicon-pencil'></span></a>&nbsp;<a><span disabled class='glyphicon glyphicon-trash'></span></a></th>
                        </tr>
                        
                ";
                else {
                    if ($eliminado == 1)
                        echo "

                        <tr style='color: #2a2828; background-color: #ff6661;'>
                            <th><a href='perfil?username=$username'>$username</a></th>
                            <th>$email</th>
                            <th>$dataRegisto</th>
                            <th>$eliminado</th>
                            <th>$perfil</th>
                            <th>$steamId</th>
                            <th><a href='editarperfil?id=$userID'><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;<a href='utilizadores.php?du=$userID'><span class='glyphicon glyphicon-trash'></span></a></th>
                        </tr>

                ";
                    else
                        echo "

                        <tr style='color: #2a2828; background-color: #adde99;'>
                            <th><a href='perfil?username=$username'>$username</a></th>
                            <th>$email</th>
                            <th>$dataRegisto</th>
                            <th>$eliminado</th>
                            <th>$perfil</th>
                            <th>$steamId</th>
                            <th><a href='editarperfil?id=$userID'><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;<a href='utilizadores.php?du=$userID'><span class='glyphicon glyphicon-trash'></span></a></th>
                        </tr>

                ";
                }

            }
            echo '</table></div>';
        }
        else{
            echo "Não existem utilizadores na base de dados!";
        }
    }
    public function getGames(){
        $connection  = $this->connect();
        $sql = "SELECT * FROM jogos WHERE id_jogo <> -1";

        $jogos = $connection->query($sql);


        if($jogos->num_rows >0){
            $count = 6;
            while ($row = $jogos->fetch_assoc()){

                $count--;

                if($count < 6 && $count >=0){

                    $nameOfGame = $row["nome"];
                    $imgUrl = $row["imagem"];
                    $print_ = '
                    <div class="col-md-4" style="padding-top: 15px;">
                        <div class="hovereffect">
                            <img alt=""  href="#" class="img-responsive" src="'.$imgUrl.'">
                                <div class="overlay">
                                    <h2>';
                    $print_ .="                    <a href='jogadores?jogo=$nameOfGame'>$nameOfGame</a>
                                    </h2>
                                </div>
                            </img>
                        </div>
                    </div>
                    ";
                    echo $print_;

                }

            }

        }else{
            echo "Não existem jogos na base de dados!";
        }
    }
    
    public function getGames_ID($id){
        $connection  = $this->connect();
        $sql = "SELECT * FROM jogos WHERE id_jogo = $id";

        $jogos = $connection->query($sql);


        if($jogos->num_rows >0){
            while ($row = $jogos->fetch_assoc()) {
                $nameOfGame = $row["nome"];
                $imgUrl = $row["imagem"];
                echo $imgUrl;
            }
        }
        return 0;
    }
    public function getGamesIDWithNome($nome){
        $connection  = $this->connect();
        $sql = "SELECT * FROM jogos WHERE nome = '$nome'";

        $jogos = $connection->query($sql);


        if($jogos->num_rows >0){
            while ($row = $jogos->fetch_assoc()) {
                return $row["id_jogo"];
            }
        }
        return 0;
    }
    public function steamConnection($idUser){
        $connection  = $this->connect();
        $sql = "SELECT steamId FROM utilizadores WHERE steamId <> 0 AND id_utilizador = $idUser";

        $utilizadores = $connection->query($sql);

        if($utilizadores->num_rows > 0){
            return true;
        }
        return false;
    }
    public function addEstatisticasJogo($idJogo,$idUser,$steamid){
        include_once ("includes/classes.php");
        $functions = new functions();

        if($functions->userHaveGame($idUser,$idJogo,$steamid)){
            $connection  = $this->connect();

            $sql = "SELECT * FROM estatisticas WHERE id_utilizador = $idUser AND id_jogo =$idJogo";

            $estatisticas = $connection->query($sql);
            //O metodo tem de ser chamado aqui pois aqui os valores são alterados
            $this->updateStats($idJogo,$idUser,$steamid);

            if($estatisticas->num_rows == 0) {
                echo "<script>swal('Novo jogo!', 'Adicionado um novo jogo na sua conta!', 'info')</script>";
            }
        }else{
            echo "<script>swal('Erro ao adicionar!', 'Não possuis esse jogo!', 'error')</script>";
        }

    }

    public function updateStats($id_jogo,$id_utilizador,$steamid){
        include_once ("includes/classes.php");
        $functions = new functions();

        $connection  = $this->connect();
        $sql = "SELECT * FROM estatisticas WHERE id_utilizador = $id_utilizador AND id_jogo =$id_jogo";
        $estatisticas = $connection->query($sql);

        $api = "API KEY WHERE";
        $var = "{$id_utilizador}_stats_{$id_jogo}_";
        $url = "http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid={$id_jogo}&key={$api}&steamid={$steamid}";
        if($functions->steamIsUp($url)) {


            $profile = file_get_contents($url);
            $buffer = fopen("cache/{$var}{$steamid}.json", "w+");
            fwrite($buffer, $profile);
            fclose($buffer);
            $steam = json_decode(file_get_contents("cache/{$var}{$steamid}.json"), true);

            $lastmatch_kills = 0;
            $lastmatch_deaths = 0;
            $total_kills = 0;
            $total_deaths = 0;
            $total_wins = 0;
            $total_loses = 0;
            $count = count($steam["playerstats"]["stats"]);
            //echo $count;
            for ($i = 0; $i < $count; $i++) {
                if ($steam["playerstats"]["stats"][$i]["name"] != "") {
                    switch ($steam["playerstats"]["stats"][$i]["name"]) {
                        case "last_match_kills":
                            $lastmatch_kills = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "last_match_deaths":
                            $lastmatch_deaths = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "last_match_favweapon_id":
                            $lastmatch_bestweapon = $functions->getWeapon($steam["playerstats"]["stats"][$i]["value"]);
                            break;
                        case "last_match_mvps":
                            $lastmatch_mvp = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "total_wins":
                            $total_wins = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "total_rounds_played":
                            $total_loses = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "total_kills":
                            $total_kills = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "total_deaths":
                            $total_deaths = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "last_match_favweapon_kills":
                            $lastmatch_weapon_kills = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "last_match_deaths":
                            $lastmatch_deaths = $steam["playerstats"]["stats"][$i]["value"];
                            break;
                        case "total_time_played":
                            $tempoJogado = $functions->convertSecondsToHour($steam["playerstats"]["stats"][$i]["value"]);
                            break;
                    }
                }
            }
            $percentagemVitorias = $functions->percentagemVitorias($total_wins, $total_loses);
            $lastmatch_kd = $functions->calcularKD($lastmatch_kills, $lastmatch_deaths);
            $kills_deaths = $functions->calcularKD($total_kills, $total_deaths);
            $mapaMaisJogado = $functions->getMapaMaisJogado($id_utilizador, $id_jogo, $steamid);
            $mapaMaisJogadoWins = $functions->getMapaMaisJogadoWins($id_utilizador, $id_jogo, $steamid);
            $var2 = "{$id_utilizador}_mapa_{$id_jogo}_";
            unlink("cache/{$var2}{$steamid}.json");

            if ($estatisticas->num_rows > 0) {
                $sql1 = "UPDATE estatisticas SET tempoJogado=$tempoJogado,percentagemVitorias=$percentagemVitorias,kills_deaths=$kills_deaths,lastmatch_bestweapon='$lastmatch_bestweapon',lastmatch_mvp=$lastmatch_mvp,mapaMaisJogado='$mapaMaisJogado',lastmatch_weapon_kills=$lastmatch_weapon_kills,mapaMaisJogadoWins=$mapaMaisJogadoWins,lastmatch_kd=$lastmatch_kd WHERE id_utilizador = $id_utilizador AND id_jogo = $id_jogo";
                unlink("cache/{$var}{$steamid}.json");
            } else {
                $sql1 = "INSERT INTO estatisticas (id_estatistica, id_utilizador, id_jogo, tempoJogado, lastmatch_kd, percentagemVitorias, kills_deaths, lastmatch_bestweapon, lastmatch_mvp,mapaMaisJogado,lastmatch_weapon_kills,mapaMaisJogadoWins)
            VALUES (0, $id_utilizador, $id_jogo, $tempoJogado, $lastmatch_kd, $percentagemVitorias, $kills_deaths, '$lastmatch_bestweapon',$lastmatch_mvp,'$mapaMaisJogado',$lastmatch_weapon_kills,$mapaMaisJogadoWins)";
                unlink("cache/{$var}{$steamid}.json");
            }
            $connection->query($sql1);
            //echo "<p style='color:red'>DEBUG: IdUser: $id_utilizador, IdJogo: $id_jogo, LastMatch_BestWeapon: $lastmatch_bestweapon ,TempoJogado: $tempoJogado , percentagemVitorias: $percentagemVitorias , lastmatch_kd: $lastmatch_kd, kd: $kills_deaths, lastmatch_mvp: $lastmatch_mvp</p>";
            //echo "<p style='color:red'>DEBUG: update com sucesso!</p>";
            //echo "<p style='color:green'>DEBUG: $lastmatch_weapon_kills </p>";
            //echo "<script>swal('DEBUG!', '$lastmatch_weapon_kills/IDJOGO:$id_jogo/IDUTILIZADOR:$id_utilizador/STEAMID:$steamid/QUERY:$sql1 ', 'info')</script>";
        }
    }

    public function getUsersToPlay($pagina,$idJogo,$nomeJogador = NULL,$kd = NULL,$mapaMaisJogado = NULL,$perVitorias = NULL,$nivelPericia = NULL,$nivelpericiaoperador = NULL,$nivelReputacao = NULL,$nivelreputacaoperador = NULL){
        $sql = null;
        $niveis = array(1,2,3,4,5,6,7,8,9,10);
        $operadores = array("<=","=",">=");
        $numToShow = 20;
        $startFrom = ($pagina-1) * $numToShow;

        if($nomeJogador != NULL || $kd != NULL || $mapaMaisJogado != NULL || $perVitorias != NULL || $nivelPericia != NULL || $nivelpericiaoperador != NULL || $nivelReputacao != NULL || $nivelreputacaoperador != NULL) {
            if(!empty($mapaMaisJogado) && substr($mapaMaisJogado, 0, 2) != 'de')
                $mapaMaisJogado = "de_".$mapaMaisJogado;

            $sql = "
            SELECT utilizadores.username,utilizadores.avatar_url,utilizadores.id_utilizador FROM utilizadores,estatisticas,avaliacoes 
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

            $sql .= " ORDER BY utilizadores.username ASC LIMIT $startFrom, $numToShow";

        }else{
            $sql = "SELECT * FROM utilizadores WHERE id_jogo = $idJogo ORDER BY username ASC LIMIT $startFrom, $numToShow";
        }
        $jogadores = $this->query($sql);

        if($jogadores->num_rows > 0){

            while ($row = $jogadores->fetch_assoc()){
                $idUser = $row["id_utilizador"];
                $username = $row["username"];
                $avatarJogador = $row["avatar_url"];
                $np = round($this->getNP($idUser,$idJogo));
                $nr = round($this->getNR($idUser,$idJogo));
                $print_ = '
                <div class="col-md-2" style="padding-top: 15px;">
                    <div class="hovereffect card-3">
                        <img alt=""  href="" class="img-responsive" src="'.$avatarJogador.'">
                            <div class="overlay">
                                <h2>';
                $print_ .="                    <a href='perfil?username=$username'>$username</a>
                                </h2>
                                <div class='progress'>
                                  <div data-toggle='tooltip' title='NP: Nível de Perícia' class='progress-bar progress-oyg-np-$np' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100'>
                                    NP: {$np}
                                  </div>
                                </div>
                                <div class='progress'>
                                  <div data-toggle='tooltip' title='NP: Nível de Reputação' class='progress-bar progress-oyg-np-$nr' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100'>
                                    NR: {$nr}
                                  </div>
                                </div>
                            </div>
                        </img>
                    </div>
                </div>
                ";
                echo $print_;

            }

        }
        else{
            echo "Não existem jogadores disponíveis neste momento!";
        }
    }

    public function getConvitesPendentes($idUser){
        $connection = $this->connect();
        $sql = "SELECT * FROM convites WHERE id_utilizadorConvidado = $idUser AND estado = 'Pendente'";
        $resultado = $connection->query($sql);
        if($resultado->num_rows > 0){
            return true;
        }

        return false;
    }

    public function getConvites($pagina,$idUser,$estado = null){
        $numToShow = 20;
        $userLogado = $this->getName($idUser);
        $startFrom = ($pagina-1) * $numToShow;
        $sql = null;

        if($estado != null){
            $sql = "SELECT * FROM convites,utilizadores WHERE (convites.id_utilizadorConvidado = $idUser OR convites.id_utilizador = $idUser) AND convites.id_utilizador = utilizadores.id_utilizador AND convites.estado = '$estado' ORDER BY convites.id_Convite DESC LIMIT $startFrom, $numToShow";
        }else{
            $sql = "SELECT * FROM convites,utilizadores WHERE (convites.id_utilizadorConvidado = $idUser OR convites.id_utilizador = $idUser) AND convites.id_utilizador = utilizadores.id_utilizador ORDER BY id_Convite DESC LIMIT $startFrom, $numToShow";;
        }
        $convites = $this->query($sql);


        if($convites->num_rows > 0){

            while ($row = $convites->fetch_assoc()){

                $usernameConvidou = $this->getName($row["id_utilizador"]);
                $estado = $row["estado"];
                $avatarJogador = $row["avatar_url"];
                $idConvite = $row["id_Convite"];
                $aceite = "Aceitar";
                $recusado = "Recusar";
                //Verifica se foi o utilizador que tem o login feito que convidou.
                if($usernameConvidou == $userLogado){
                    $usernameConvidou = $this->getName($row["id_utilizadorConvidado"]);
                    echo "                
                    <div class='col-md-3' style='padding-top: 15px;'>
                        <div class='hovereffect card-3'>
                            <img alt='' href='' class='img-responsive'' src='{$this->getAvatarURL($row['id_utilizadorConvidado'])}'>
                                <div class=\"overlay\">
                                    <h2><a href='perfil?username=$usernameConvidou'>$usernameConvidou</a>
                                    <h3 style='color: greenyellow'>Convite enviado</h3>
                                    <p>Estado: $estado</p></h2>
                                    
                                    <!--<a href='convite?id=$idConvite&estado=$aceite'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Aceitar</button></small></a>
                                    <a href='convite?id=$idConvite&estado=$recusado'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Recusar</button></small></a>-->
                                </div>
                            </img>
                        </div>
                    </div>";
                }else{
                    if($estado == "Pendente"){
                        echo "                
                        <div class='col-md-3' style='padding-top: 15px;'>
                            <div class='hovereffect card-3'>
                                <img alt='' href='' class='img-responsive'' src='$avatarJogador'>
                                    <div class=\"overlay\">
                                        <h2><a href='perfil?username=$usernameConvidou'>$usernameConvidou</a>
                                        <h3 style='color: yellow'>Convite recebido</h3>
                                        <p>Estado: $estado</p></h2>
                                        
                                        <a href='convite?id=$idConvite&estado=$aceite'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Aceitar</button></small></a>
                                        <a href='convite?id=$idConvite&estado=$recusado'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Recusar</button></small></a>
                                    </div>
                                </img>
                            </div>
                        </div>";
                        return;
                    }elseif($estado == "Aceite") {
                        echo "                
                        <div class='col-md-3' style='padding-top: 15px;'>
                            <div class='hovereffect card-3'>
                                <img alt='' href='' class='img-responsive'' src='$avatarJogador'>
                                    <div class=\"overlay\">
                                        <h2><a href='perfil?username=$usernameConvidou'>$usernameConvidou</a>
                                        <h3 style='color: green'>Convite recebido</h3>
                                        <p>Estado: $estado</p></h2>
                                        
                                        <a href='convite?id=$idConvite&estado=Recusar'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Apagar convite</button></small></a>
                                        <!--<a href='convite?id=$idConvite&estado=$recusado'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Recusar</button></small></a>--<>
                                    </div>
                                </img>
                            </div>
                        </div>";
                    }elseif($estado == "Recusado"){
                        echo "                
                        <div class='col-md-3' style='padding-top: 15px;'>
                            <div class='hovereffect card-3'>
                                <img alt='' href='' class='img-responsive'' src='$avatarJogador'>
                                    <div class=\"overlay\">
                                        <h2><a href='perfil?username=$usernameConvidou'>$usernameConvidou</a>
                                        <h3 style='color: red'>Convite recebido</h3>
                                        <p>Estado: $estado</p></h2>
                                        
                                        <!--<a href='convite?id=$idConvite&estado=$aceite'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Aceitar</button></small></a>
                                        <a href='convite?id=$idConvite&estado=$recusado'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Recusar</button></small></a>-->
                                    </div>
                                </img>
                            </div>
                        </div>";
                    }

                }


            }

        }
        else{
            echo "Não existem convites disponíveis neste momento!";
        }
    }

    public function convidaJogador($jogadorConvida,$jogadorConvidado){
        include_once ("includes/classes.php");
        $functions = new functions();
        $data = $functions->gethoraData();
        $connection  = $this->connect();
        $sql = "INSERT INTO convites (id_Convite, estado, dataConvite, id_utilizadorConvidado, id_utilizador)
            VALUES (0, 'Pendente', '$data', $jogadorConvidado, $jogadorConvida)";

        $connection->query($sql);

    }
    public function userConvidouUser($idUtilizador,$id_utilizadorConvidado){
        $connection = $this->connect();
        $sql = "SELECT * FROM convites WHERE id_utilizador = $idUtilizador AND id_utilizadorConvidado = $id_utilizadorConvidado AND estado = 'Aceite'";
        $resultado = $connection->query($sql);
        if($resultado->num_rows > 0){
            return true;
        }

        return false;
    }

    public function getSteamProfileLink($idUser){
        $connection = $this -> connect();
        $sql = "SELECT steamProfileLink FROM utilizadores WHERE id_utilizador = $idUser";
        $resultado = $connection->query($sql);

        if ($resultado->num_rows > 0) {
            // output data of each row
            while($row = $resultado->fetch_assoc()) {
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                return $row["steamProfileLink"];
            }
        }
        return 0;
    }

    public function irListaJogadoresDisponiveis($idUser,$idJogo){
        $connection  = $this->connect();
        $sql = "UPDATE utilizadores SET id_jogo = $idJogo WHERE id_utilizador = $idUser";

        $connection->query($sql);
    }
    public function sairListaJogadoresDisponiveis($idUser,$idJogo){
        $connection  = $this->connect();
        $sql = "UPDATE utilizadores SET id_jogo = 0 WHERE id_utilizador = $idUser";
        $sql1 = "SELECT username,id_jogo FROM utilizadores WHERE id_utilizador = $idUser AND id_jogo = $idJogo";

        $resultado = $connection->query($sql1);

        if($resultado->num_rows > 0){
            $connection->query($sql);
        }

    }
    public function jogoExist($jogo = null,$id = null){
        $connection  = $this->connect();
        if($jogo != null)
            $sql = "SELECT * FROM jogos WHERE nome = '$jogo'";
        if($id != null)
            $sql = "SELECT * FROM jogos WHERE id_jogo = {$id}";

        $jogos = $connection->query($sql);


        if($jogos->num_rows >0){
            return true;
        }
        return false;
    }
    public function denunciaJogador($idUserLogado,$idUserPerfil,$texto){
        include_once ("includes/classes.php");
        $functions = new functions();
        $data = $functions->getData();
        $connection  = $this->connect();
        $sql = "INSERT INTO denuncias (ID_UtilizadorQueixoso, ID_UtilizadorDenunciado, Texto,data)
            VALUES ($idUserLogado,$idUserPerfil,'$texto','$data')";

        $connection->query($sql);
    }
    public function getDefinicoes(){
        $connection  = $this->connect();
        $sql = "SELECT * FROM definicoes";

        $definicoes = $connection->query($sql);


        if($definicoes->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Manutenção</th>
                            <th>Opções</th>
                        </tr>
            ';
            while ($row = $definicoes->fetch_assoc()){
                $manutencao = $row["manutencao"];
                if($manutencao == 0){
                    echo"
                    <tr>
                        <th class='col-md-1'>$manutencao</th>
                        <th style='cursor:pointer; !important;' onclick='manutencao(1);' class='col-md-1'><span class='glyphicon glyphicon-eye-open'></span></th>
                    </tr>
                    ";
                }
                if($manutencao == 1){
                    echo"
                    <tr>
                        <th class='col-md-1'>$manutencao</th>
                        <th style='cursor:pointer; !important;' onclick='manutencao(0);' class='col-md-1'><span class='glyphicon glyphicon-eye-open'></span></th>
                    </tr>
                    ";
                }


            }
            echo '</table></div>';

        }else{
            echo "Não existem jogos na base de dados!";
        }
    }
//Forum Functions ----------------------------------------
    public function existTopico($idTopico){
        $connection = $this -> connect();

        $sql = "SELECT * FROM topicos WHERE ID_Topico = $idTopico";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function getTopicos($idJogo,$pagina){
        $numToShow = 20;


        $startFrom = ($pagina-1) * $numToShow;
        $topicos = $this->query("
        SELECT topicos.*,COUNT(respostas.ID_Topico) AS numeroRespostas,utilizadores.username
        FROM topicos
        LEFT JOIN respostas
        ON respostas.ID_Topico = topicos.ID_Topico
        RIGHT JOIN utilizadores
        ON utilizadores.id_utilizador = topicos.ID_Utilizador
        WHERE topicos.ID_Jogo = $idJogo
        GROUP BY topicos.ID_Topico
        ORDER BY topicos.ID_Topico DESC
        LIMIT $startFrom, $numToShow
        ");

        if($topicos->num_rows > 0){

            while ($row = $topicos->fetch_assoc()){

                $id = $row["ID_Topico"];
                $nome = $row["Nome"];
                $descricao = $row["Descricao"];
                $username = $row["username"];
                $numeroRespostas = $row["numeroRespostas"];
                $categoria = $row["Categoria"];
                $dataHora = $row["datahora"];
                //ID_Utilizador
                //ID_Jogo
                //Categoria

                $print_ = '
                
                            <div class="large-12 forum-topic">
                                <div class="large-1 column lpad">
                                    <i class="icon-file"></i>
                                </div>
                                <div class="large-7 small-8 column lpad">
                                    <span class="overflow-control">
                                      <a href="topico?id='.$id.'">'.$nome.'</a>
                                    </span>
                                    <span class="overflow-control">'.$descricao.'</span>
                                </div>
                                <div class="large-1 column lpad">
                                    
                                </div>
                                <div class="large-1 column lpad">
                                    <span class="center">'.$numeroRespostas.'</span>
                                </div>
                                <div class="large-2 small-4 column pad">
                                <span>
                                  <a href="#">'.$categoria.'</a>
                                </span>
                                    <span>'.$dataHora.'</span>
                                    <span>por <a href="../perfil?username='.$username.'">'.$username.'</a></span>
                                </div>
                            </div>
                
                        
                ';
                echo $print_;

            }

        }
        else{
            echo "Não existem tópios neste forum!";
        }
    }
    public function verificaTopicoDescricao($topico,$descricao){
        $connection = $this -> connect();

        $sql = "SELECT * FROM topicos WHERE Nome = '$topico' AND Descricao = '$descricao'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function getGamesForuns(){
        $connection  = $this->connect();
        $sql = "SELECT * FROM jogos WHERE id_jogo <> -1";

        $jogos = $connection->query($sql);


        if($jogos->num_rows >0){
            $count = 6;
            while ($row = $jogos->fetch_assoc()){

                $count--;

                if($count < 6 && $count >=0){

                    $nameOfGame = $row["nome"];
                    $imgUrl = $row["imagem"];
                    $print_ = '
                    <div class="col-md-4" style="padding-top: 15px;">
                        <div class="hovereffect">
                            <img alt=""  href="#" class="img-responsive" src="'.$imgUrl.'">
                                <div class="overlay">
                                    <h2>';
                    $print_ .="<a href='forum?jogo=$nameOfGame'>$nameOfGame</a>
                                    </h2>
                                </div>
                            </img>
                        </div>
                    </div>
                    ";
                    echo $print_;
                }
            }
        }
        else{
            echo "Não existem jogos na base de dados!";
        }
    }

    public function getTopico($idTopico){
        $rows = array();
        $connection  = $this->connect();
        $sql = "SELECT * FROM topicos WHERE ID_Topico = $idTopico";

        $topicos = $connection->query($sql);


        if($topicos->num_rows >0){
            $row = $topicos->fetch_assoc();
            return $row;
        }
        return 0;
    }
    public function getRespostas($idTopico){
        $connection  = $this->connect();
        $sql = "SELECT * FROM respostas INNER JOIN utilizadores ON utilizadores.id_utilizador = respostas.ID_Utilizador WHERE ID_Topico = $idTopico ORDER BY ID_Resposta DESC";

        $respostas = $connection->query($sql);


        if($respostas->num_rows >0){
            while ($row = $respostas->fetch_assoc()){


                $texto = $row["Texto"];
                $username = $row["username"];
                $perfil = $row["perfil"];
                $avatar = $row["avatar_url"];
                $dataHora = $row["dataHora"];

                $splitHoraData = explode(" ",$dataHora);
                $hora = $splitHoraData[1];

                setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
                date_default_timezone_set('Europe/London');

                $dataTexto = strftime('%A, %d de %B de %Y', strtotime($dataHora)) . " às $hora";

                if($perfil == 3){
                    echo "                
                    <div class='media'>
                        <a class='pull-left' href=''>
                            <img class='media-object' width='64' src='../$avatar' alt=''>
                        </a>
                        <div class='media-body'>
                            <h4 style='color: #ffaa17' class='media-heading'>Fundador: <a href='../perfil?username=$username'>$username</h4></a>
                            <h4><small>$dataTexto</small></h4>
                            $texto
                        </div>
                    </div>";
                }
                if($perfil == 2){
                    echo "                
                    <div class='media'>
                        <a class='pull-left' href=''>
                            <img class='media-object' width='64' src='../$avatar' alt=''>
                        </a>
                        <div class='media-body'>
                            <h4 style='color: #FF0000' class='media-heading'>Admin: <a href='../perfil?username=$username'>$username</h4></a>
                            <h4><small>$dataTexto</small></h4>
                            $texto
                        </div>
                    </div>";
                }
                if($perfil == 1){
                    echo "                
                    <div class='media'>
                        <a class='pull-left' href=''>
                            <img class='media-object' width='64' src='../$avatar' alt=''>
                        </a>
                        <div class='media-body'>
                            <h4 style='color: #00DFFC' class='media-heading'>Membro: <a href='../perfil?username=$username'>$username</h4></a>
                            <h4><small>$dataTexto</small></h4>
                            $texto
                        </div>
                    </div>";
                }


            }

        }else{
            echo "Sem comentários!";
        }
    }

    public function novoComentario($idTopico,$idUser,$texto){
        $connection  = $this->connect();
        $texto = $this->quote($texto);
        $idTopico = $this->quote($idTopico);
        $idUser = $this->quote($idUser);
        $sql = "INSERT INTO respostas (Texto,ID_Topico,ID_Utilizador) VALUES ('$texto','$idTopico','$idUser')";

        $connection->query($sql);
    }
    public function topicoIsFromUser($idUser,$idTopico){
        $connection  = $this->connect();
        $sql = "SELECT * FROM topicos WHERE ID_Topico = $idTopico AND ID_Utilizador = $idUser";

        $topicos = $connection->query($sql);

        if($topicos->num_rows > 0){
            return true;
        }
        return false;
    }
    public function getTopicosUser($idUser,$pagina){
        $numToShow = 20;


        $startFrom = ($pagina-1) * $numToShow;
        $connection  = $this->connect();
        $sql = "SELECT * FROM topicos WHERE ID_Utilizador = $idUser ORDER BY ID_Topico DESC LIMIT $startFrom, $numToShow";

        $topicos = $connection->query($sql);

        if($topicos->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Opções</th>
                        </tr>
            ';
            while ($row = $topicos->fetch_assoc()){
                $sugestionID = $row["ID_Topico"];
                $categoria = $row["Categoria"];
                $descricao = $row["Descricao"];

                echo'
                    <tr>
                        <th class="col-md-1">'.$sugestionID.'</th>
                        <th class="col-md-2">'.$categoria.'</th>
                        <th>'.$descricao.'</th>
                        <th class="col-md-1"><a href="topico?id='.$sugestionID.'"><span class="glyphicon glyphicon-eye-open"></span></a></th>
                    </tr>
                    ';

            }
            echo '</table></div>';
        }
        else{
            echo "Não existem sugestões na base de dados!";
        }
    }
    public function getSugestions($pagina){
        $numToShow = 20;


        $startFrom = ($pagina-1) * $numToShow;
        $connection  = $this->connect();
        $sql = "SELECT * FROM sugestoes ORDER BY ID_Sugestao DESC LIMIT $startFrom, $numToShow";

        $sugestoes = $connection->query($sql);

        if($sugestoes->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>ID Sugestão</th>
                            <th>Categoria</th>
                            <th>Texto</th>
                            <th>Opções</th>
                        </tr>
            ';
            while ($row = $sugestoes->fetch_assoc()){
                $sugestionID = $row["ID_Sugestao"];
                $categoria = $row["Categoria"];
                $texto = $row["Texto"];
                $vista = $row["Vista"];
                $pelica = "'$texto'";

                if ($vista == 0) {
                    echo'
                    <tr style="color: #2a2828; background-color: #f5ff00;">
                        <th style="cursor: pointer; !important;" onclick="swal('.$pelica.');" class="col-md-1"><a>'.$sugestionID.'</a></th>
                        <th>'.$categoria.'</th>
                        <th>'.$texto.'</th>
                        <th class="col-md-1"><a href="sugestoes.php?cid='.$sugestionID.'"><span class="glyphicon glyphicon-ok"></span></a>&nbsp;<a href="sugestoes?rid='.$sugestionID.'"><span class="glyphicon glyphicon-trash"></span></a></th>
                    </tr>
                    ';
                }

                else{
                    echo'
                    <tr style="color: #2a2828; background-color: #44bb07;">
                        <th style="cursor: pointer; !important;" onclick="swal('.$pelica.');" class="col-md-1"><a>'.$sugestionID.'</a></th>
                        <th>'.$categoria.'</th>
                        <th>'.$texto.'</th>
                        <th class="col-md-1"><a href="sugestoes.php?uid='.$sugestionID.'"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;<a href="sugestoes?rid='.$sugestionID.'"><span class="glyphicon glyphicon-trash"></span></a></th>
                    </tr>
                    ';
                }
            }
            echo '</table></div>';
        }
        else{
            echo "Não existem sugestões na base de dados!";
        }
    }
    public function getCategorias($pagina){
        $numToShow = 20;


        $startFrom = ($pagina-1) * $numToShow;
        $connection  = $this->connect();
        $sql = "SELECT * FROM categorias ORDER BY Nome DESC LIMIT $startFrom, $numToShow";

        $categorias = $connection->query($sql);

        if($categorias->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Nome</th>
                            <th>Opções</th>
                        </tr>
            ';
            while ($row = $categorias->fetch_assoc()){
                $nome = $row["Nome"];

                echo'
                    <tr>
                        <th class="col-md-6"><a>'.$nome.'</th>
                        <th class="col-md-1"><a href="categorias?rcid='.$nome.'"><span class="glyphicon glyphicon-trash"></span></a></th>
                    </tr>
                    ';
            }
            echo '</table></div>';
        }
        else{
            echo "Não existem categorias na base de dados!";
        }
    }


    public function getDenuncias($pagina){
        $numToShow = 20;
        $startFrom = ($pagina-1) * $numToShow;
        $connection  = $this->connect();
        $sql = "SELECT * FROM denuncias ORDER BY ID_Denuncia DESC LIMIT $startFrom, $numToShow";
        


        $denuncias = $connection->query($sql);

        if($denuncias->num_rows >0){
            echo '
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>ID Denuncia</th>
                            <th>Utilizador Queixoso</th>
                            <th>Utilizador Denunciado</th>
                            <th>Texto</th>
                            <th>Data</th>
                        </tr>
            ';
            while ($row = $denuncias->fetch_assoc()){
                $id_denuncia = $row["ID_Denuncia"];
                $id_utilizadorQueixoso = $row["ID_UtilizadorQueixoso"];
                $id_utilizadorDenunciado = $row["ID_UtilizadorDenunciado"];
                $texto = $row["Texto"];
                $data = $row["data"];

                $usernameQueixoso = $this->getName($id_utilizadorQueixoso);
                $usernameDenunciado = $this->getName($id_utilizadorDenunciado);

                echo'
                    <tr>
                        <th><a href="denuncia?id='.$id_denuncia.'">'.$id_denuncia.'</a></th>
                        <th><a href="perfil?username='.$usernameQueixoso.'">'.$usernameQueixoso.'</a></th>
                        <th><a href="perfil?username='.$usernameDenunciado.'">'.$usernameDenunciado.'</a></th>
                        <th>'.$texto.'</th>
                        <th>'.$data.'</th>
                   </tr>
                ';
            }
            echo '</table></div>';
        }
        else{
            echo "Não existem sugestões na base de dados!";
        }
    }
}
?>
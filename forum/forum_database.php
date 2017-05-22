<?php
class DatabaseKneeler {
    protected static $connection;

    public function connect() {    

        if(!isset(self::$connection)) {
            $config = parse_ini_file('../includes/config.ini'); 
            self::$connection = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);
        }

        if(self::$connection === false) {
            return false;
        }
        return self::$connection;
    }

    public function query($query) {
        $connection = $this -> connect();

        $result = $connection -> query($query);

        return $result;
    }

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

    public function error() {
        $connection = $this -> connect();
        return $connection -> error;
    }

    public function quote($value) {
        $connection = $this -> connect();
        return $connection -> real_escape_string($value); 
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
        $sql = "SELECT * FROM Utilizadores WHERE username = '".$username."' OR email = '".$email."'";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            return 1;
        }
    }

    public function getName($id_user){
        $connection = $this->connect();
        $sql = "SELECT username FROM Utilizadores WHERE id_utilizador = '$id_user'";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                return $row["username"];
            }
        }
    }

    public function getAvatarURL($id){
        $connection = $this->connect();
        $sql = "SELECT * FROM Utilizadores WHERE id_utilizador = $id";

        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                return $row["avatar_url"];
            }
        }
    }

    public function getUsers(){
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
                echo'

                        <tr>
                            <th><a href="perfil?user='.$username.'">'.$username.'</a></th>
                            <th>'.$email.'</th>
                            <th>'.$dataRegisto.'</th>
                            <th>'.$eliminado.'</th>
                            <th>'.$perfil.'</th>
                            <th>'.$steamId.'</th>
                            <th><a href="editarUser?id='.$userID.'"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="removerUser?id='.$userID.'"><span class="glyphicon glyphicon-trash"></span></a></th>
                        </tr>
                ';
            }
            echo '</table></div>';
        }
        else{
            echo "Não existem utilizadores na base de dados!";
        }
    }

    public function getGamesForuns(){
        $connection  = $this->connect();
        $sql = "SELECT * FROM jogos";

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

    public function getGames_ID($id){
        $connection  = $this->connect();
        $sql = "SELECT * FROM Jogos WHERE id_jogo = $id";

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
}
?>
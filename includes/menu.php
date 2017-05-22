<link rel="icon" href="images/icon.png" type="image/x-icon" />
<div id="notification" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index">
	        	<img style="margin-top: -10%" src="images/icon.png">
	        </a>
            <a class="navbar-brand" href="index">OpenYourGame</a>
            <button class="navbar-toggle" data-target="#navbar-main" data-toggle="collapse" type="button">
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="active_ice barrinha">
                    <a class="active_ice two" href="index">
                        Encontrar Jogadores
                    </a>
                </li>
                <li class="barrinha">
                    <a href="forum/index">
                        Forum
                    </a>
                </li>
                <li class="barrinha">
                    <a href="adicionarSugestao.php">
                        Fazer uma Sugestão
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown barrinha">
                    <?php if(isset($_SESSION["userId"])){?>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="menu0"><span class="label label-pill label-danger count"></span>Convites &nbsp<span class="glyphicon glyphicon-bell" aria-hidden="true"></span>

                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menu0" id="convites_dropdown">
                    </ul>
                    <?php }?>
                </li>
                <li class="dropdown barrinha">

                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="menu1"><?php if(!isset($_SESSION["userId"])) { echo "Login/Registo";}else{require_once "database.php"; $database = new DatabaseIcen(); echo "Painel";}?>

                        <span class="caret">
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menu1">
                        <?php if(!isset($_SESSION["userId"])) { ?>
                        <li>
                            <a href="login">Login &nbsp<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
                        </li>
                        <li>
                            <a href="registar">Registar &nbsp<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span></a>
                        </li>
                        <?php } else { include_once ("database.php"); $database = new DatabaseIcen(); if($database->isAdmin($_SESSION["userId"]) == 1){?>
                        <li>
                            <a href="utilizadores">Admin &nbsp<span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                        </li>
                        <?php }?>
                        <li>
                            <a href="perfil" id="username">
                                <?php echo "Perfil (".$database->getName($_SESSION["userId"]).")"; ?>
                                &nbsp<img width="16" src="<?=$database->getAvatarURL($_SESSION["userId"])?>"></a>
                        </li>
                        <li>
                            <a href="editarperfil" id="editarperfil">
                                Editar Perfil &nbsp<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </li>
                        <li>
                            <?php include_once ("database.php"); $db = new DatabaseIcen(); if($db->steamConnection($_SESSION["userId"]) == true){?>
                            <a href="#" style="color: #0abe0d">Conectado ao Steam &nbsp;<img src="images/login-steam-icon.png"></a>
                            <?php } else {?>
                            <a href="steam">Conectar ao Steam &nbsp;<img src="images/login-steam-icon.png"></a>
                            <?php }?>
                        </li>
                        <li>
                            <?php include_once ("database.php"); $db = new DatabaseIcen(); if($db->steamConnection($_SESSION["userId"]) == true){?>
                            <a href="novoJogo">Novo jogo &nbsp<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                            <?php } else {?>
                            <a href="" style="color: red; cursor: not-allowed" title="Tem de fazer login com a steam para adicionar um jogo">Novo jogo</a>
                            <?php }?>
                        </li>
                        <li>
                            <a href="convites">Histórico de convites &nbsp<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                        </li>
                        <li>
                            <a href="../meustopicos">Meus Tópicos &nbsp<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span></a>
                        </li>
                        <li>
                            <a href="chat">Chat box &nbsp<span class="glyphicon glyphicon-comment" aria-hidden="true"></span></a>
                        </li>
                        <li>
                            <a href="logout">Sair &nbsp<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="js/invites.js"></script>
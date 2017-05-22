<?php
session_start();
include("../includes/database.php");
if(isset($_SESSION["userId"])){
    $idLogado = $_SESSION["userId"];
    $db = new DatabaseIcen();
    $html = "";
    /*if(isset($_POST["view"]) != ''){
        $db->query("UPDATE convites SET estado = 'Visto' WHERE id_utilizadorConvidado = $idLogado");
    }*/
    $convites=$db->query("SELECT * FROM convites WHERE id_utilizadorConvidado = $idLogado AND estado = 'Pendente'");
    if($convites->num_rows > 0){
        while ($row = $convites->fetch_assoc()){
            $userConvidou = $db->getName($row["id_utilizador"]);
            $idConvite = $row["id_Convite"];
            $aceite = "Aceitar";
            $recusado = "Recusar";
            $html .= "
            <li>
                
                <strong>Convite recebido de <a href='perfil?username={$userConvidou}'>{$userConvidou}</a></strong><br>
                <a href='convite?id=$idConvite&estado=$aceite'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Aceitar</button></small></a>
                <a href='convite?id=$idConvite&estado=$recusado'><small><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Recusar</button></small></a>
            </li><li class=\"divider\">
                        </li>";
        }

    }else{
        $html .= "
        <li>
            <a href='' class='text-bold text-italic'>Nenhum convite recebido</a>
        </li>";
    }
    $sql1 = "SELECT * FROM convites WHERE estado = 'Pendente' AND id_utilizadorConvidado = $idLogado";
    $resultado = $db->query($sql1);
    $rows_resultado = $resultado->num_rows;
    $data = array(
        'convites'        => $html,
        'unseen_convites' => $rows_resultado
    );
    echo json_encode($data);
}



?>
<?php
session_start();
if(isset($_REQUEST['v']) && isset($_SESSION["userId"]) && isset($_REQUEST['u']) && isset($_REQUEST['j'])) {


    include_once("../includes/database.php");
    include_once("../includes/classes.php");
    $db = new DatabaseIcen();
    $functions = new functions();

    $idUser = $db->quote($_REQUEST['u']);
    $valor = $db->quote($_REQUEST['v']);
    $idJogo = $db->quote($_REQUEST['j']);
    if($idJogo != 0) {


        $sql = "
        SELECT *
        FROM avaliacoes
        WHERE id_utilizador = $idUser AND (n_avaliacoesRep <> 0 OR nivelReputacao = 0.0 OR n_avaliacoes <> 0 OR nivelPericia = 0.0) AND id_jogo = $idJogo";

        $users = $db->query($sql);
        if ($users->num_rows == 0) {
            $sql1 = "INSERT INTO avaliacoes (n_avaliacoes,n_avaliacoesRep,nivelReputacao,nivelPericia,id_utilizador,id_jogo) VALUES (0,1,$valor,0.0,$idUser,$idJogo)";
        } else {
            $sql1 = "UPDATE avaliacoes SET n_avaliacoesRep=n_avaliacoesRep + 1,nivelReputacao=((nivelReputacao * (n_avaliacoesRep - 1)) + $valor) / n_avaliacoesRep WHERE id_utilizador = $idUser AND id_jogo = $idJogo";
        }
        $db->query($sql1);
    }
}


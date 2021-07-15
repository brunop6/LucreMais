<?php
    header('Content-Type: application/json');
    include_once './../../classes/Usuario.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_POST['email'];
    $nivelAcesso = $_POST['nivelAcesso'];
    list($idMenu, $descricaoMenu) = Usuario::selectMenusDisponiveis($nivelAcesso, $email);

    $i = 0;
    foreach($idMenu as $id){
        $json['id'][$i] = $id;
        $json['descricao'][$i] = $descricaoMenu[$i];
        $i++;
    }

    echo json_encode($json);
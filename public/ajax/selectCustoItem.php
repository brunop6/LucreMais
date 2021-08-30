<?php
    header('Content-Type: application/json');

    include_once './../../classes/Item.php';
    include_once './../../classes/Receita.php';

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email_usuario'];
    
    $item = $_POST['item'];
    $quantidade = $_POST['quantidade'];
    $unidadeMedida = $_POST['unidadeMedida'];

    $idItem = Item::selectId($item, $email);

    $custo = Receita::valorItemReceita($idItem, $unidadeMedida, $quantidade);

    echo json_encode(number_format($custo, 2));
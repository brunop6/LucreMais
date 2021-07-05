<?php
    header('Content-Type: application/json');
    include_once '../classes/Fornecedor.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email'];
    $input = $_POST['fornecedor'];
    $json = Fornecedor::buscarFornecedor($input, $email);

    echo json_encode($json);
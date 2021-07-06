<?php
    header('Content-Type: application/json');
    include_once '../../../classes/CategoriaRecibo.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email_usuario'];
    $input = $_POST['categoria'];
    $json = CategoriaRecibo::buscarCategoria($input, $email);
    
    echo json_encode($json);

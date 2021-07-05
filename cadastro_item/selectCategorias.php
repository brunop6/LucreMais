<?php
    header('Content-Type: application/json');
    include_once '../classes/Categoria.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email_usuario'];
    $input = $_POST['categoria'];

    $json = Categoria::buscarCategoria($input, $email);
    
    echo json_encode($json);

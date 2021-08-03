<?php
    header('Content-Type: application/json');
    include_once '../../classes/CategoriaDespesa.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email_usuario'];
    $input = $_POST['categoriaDespesa'];
    $json = CategoriaDespesa::buscarCategoria($input, $email);

    echo json_encode($json);
<?php
    header('Content-Type: application/json');
    include_once '../classes/Item.php';
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $email = $_SESSION['email_usuario'];
    $input = $_POST['item'];
    list($marca, $nome) = Item::selectItem($input, $email);
    
    $i = 0;
    foreach($nome as $value){
        $json[] = $value.' '.$marca[$i]; 
        $i++;
    }

    echo json_encode($json);
<?php
    header('Content-Type: application/json');
    include_once '../classes/Item.php';

    $input = $_POST['item'];
    list($marca, $nome) = Item::selectItem($input);
    
    $i = 0;
    foreach($nome as $value){
        $json[] = $value.' '.$marca[$i]; 
        $i++;
    }

    echo json_encode($json);
<?php
    header('Content-Type: application/json');
    include_once '../classes/Categoria.php';

    $input = $_POST['categoria'];
    $json = Categoria::selectCategoria($input);
    
    echo json_encode($json);

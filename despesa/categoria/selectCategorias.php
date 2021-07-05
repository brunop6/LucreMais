<?php
    header('Content-Type: application/json');
    include_once '../../classes/CategoriaDespesa.php';

    $input = $_POST['categoriaDespesa'];
    $json = Categoria::buscarCategoria($input);
    
    echo json_encode($json);

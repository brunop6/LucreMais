<?php
    header('Content-Type: application/json');
    include_once '../classes/CategoriaDespesa.php';

    $input = $_POST['categoriaDespesa'];
    $json = CategoriaDespesa::buscarCategoria($input);

    echo json_encode($json);
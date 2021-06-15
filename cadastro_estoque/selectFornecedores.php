<?php
    header('Content-Type: application/json');
    include_once '../classes/Fornecedor.php';

    $input = $_POST['fornecedor'];
    $json = Fornecedor::selectFornecedor($input);

    echo json_encode($json);
<?php
    include '../includes/conecta_bd.inc';
    include_once '../classes/Estoque.php';

    if(!isset($_GET['idFornecedor']) || !isset($_GET['idItem']) || !isset($_GET['quantidade']) || !isset($_GET['preco']) || !isset($_GET['lote'])){
        header('Location: cadastro_estoque.php');
        die();
    }

    $idUsuario = $_SESSION['nome_usuario'];
    $idFornecedor = $_GET['idFornecedor'];
    $idItem = $_GET['idItem'];
    $quantidade = $_GET['quantidade'];
    $preco = $_GET['preco'];
    $lote = $_GET['lote'];

    $estoque = new Estoque($idUsuario, $idFornecedor, $idItem, $quantidade, $preco, $lote, '1');

    $resultado = $estoque->cadastrar_estoque();

    if($resultado == 'Cadastro realizado com sucesso!'){
        echo "<h2>$resultado</h2> <br>";
    }else{
        echo '<h2>Erro ao realizar cadastro...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='../Home.php'><button>Retornar a página principal</button></a></p>";
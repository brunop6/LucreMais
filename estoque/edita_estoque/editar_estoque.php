<?php
    include '../../includes/conecta_bd.inc';
    include_once '../../classes/Estoque.php';
    include_once '../../classes/Usuario.php';

    if(!isset($_GET['id']) || !isset($_GET['idFornecedor']) || !isset($_GET['idItem']) || !isset($_GET['quantidade']) || !isset($_GET['preco']) || !isset($_GET['lote']) || !isset($_GET['status'])){
        header('Location: ./../estoque.php');
        die();
    }
    if(isset($_GET['tipo'])){
        $tipo = $_GET['tipo'];
    }else{
        $tipo = null;
    }

    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $idFornecedor = $_GET['idFornecedor'];
    $idItem = $_GET['idItem'];
    $quantidade = $_GET['quantidade'];
    $preco = $_GET['preco'];
    $lote = $_GET['lote'];
    $validade = $_GET['validade'];
    $status = $_GET['status'];
    $estoque = new Estoque($idUsuario, $idFornecedor, $idItem, $quantidade, $preco, $lote, $validade, $status);

    if($estoque->editar_estoque($id, $tipo)){
        header("Location: ./../estoque.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./../estoque.php'><button>Retornar ao Estoque</button></a></p>";
    
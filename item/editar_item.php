<?php
    include '../includes/conecta_bd.inc';
    include_once '../classes/Item.php';
    include_once '../classes/Usuario.php';
    include_once '../classes/Categoria.php';
    if(!isset($_GET['id'])){   
        header('Location: ./item.php');
        die();
    }
     
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    session_start();
    $id = $_GET['id'];
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $descricaoCategoria = $_POST['categoria'];
    $idCategoria = Categoria::selectId($descricaoCategoria);
    $quantidade = $_POST['quantidade'];
    $quantidadeMinima = $_POST['quantidadeMinima'];
    $unidadeMedida = $_POST['unidade_de_medida'];
    $nomeUsuario = $_SESSION['nome_usuario'];

    $item = new Item($idUsuario, $idCategoria, $marca, $nome, $quantidade,$unidadeMedida, $quantidadeMinima);

    if($item->editar_item($id)){
        header("Location: ./item.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./item.php'><button>Retornar</button></a></p>";
?>
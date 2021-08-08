<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../public/css/inputs.css">
    
    <title>Editar Item</title>
</head>
<body>
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
    $emailUsuario = $_SESSION['email_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $id = $_GET['id'];
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $descricaoCategoria = $_POST['categoria'];
    $idCategoria = Categoria::selectId($descricaoCategoria, $emailUsuario);
    $quantidade = $_POST['quantidade'];
    $quantidadeMinima = $_POST['quantidadeMinima'];
    $unidadeMedida = $_POST['unidade_de_medida'];

    $item = new Item($idUsuario, $idCategoria, $marca, $nome, $quantidade, $unidadeMedida, $quantidadeMinima);
    
    if($item->editar_item($id)){
        header("Location: ./item.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./item.php'><button>Retornar</button></a></p>";
?>
</body>
</html>
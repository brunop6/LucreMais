<?php
    include '../includes/conecta_bd.inc';
    include_once '../classes/Item.php';
    include_once '../classes/Usuario.php';
    
  /*  if(!isset($_GET['id'])){   
       header('Location: ./item.php');
        die();
    echo "Variável não definida";
        }*/
    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $idCategoria = $_POST['categoria'];
    $quantidade = $_POST['quantidade'];
    $quantidadeMinima = $_POST['quantidadeMinima'];
    $unidadeMedida = $_POST['unidade_de_medida'];

    $item = new Item($idUsuario, $idCategoria, $marca, $nome, $quantidade,$unidadeMedida, $quantidadeMinima);
    $id = $_GET['id'];

  if($item->editar_item($id)){
        header("Location: ./item.php");
        
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
       echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./item.php'><button>Retornar</button></a></p>";

?>
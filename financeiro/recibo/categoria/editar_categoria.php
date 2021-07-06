<?php
    include_once '../../../classes/CategoriaRecibo.php';
    include_once '../../../classes/Usuario.php';

    if(!isset($_GET['id']) || !isset($_POST['categoriaRecibo'])){
        header('Location: categoria.php');
        die();
    }
    
    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $descricao = $_POST['categoriaRecibo'];

    $categoria = new CategoriaRecibo($descricao);

    if($categoria->editarCategoria($id)){
        header("Location: ./categoria.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./categoria.php'><button>Retornar às Categorias</button></a></p>";
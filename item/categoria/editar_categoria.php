<?php
    include_once '../../classes/Categoria.php';
    include_once '../../classes/Usuario.php';

    if(!isset($_GET['id']) || !isset($_POST['categoria'])){
        header('Location: categoria.php');
        die();
    }
    
    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $descricaoCategoria = $_POST['categoria'];

    $categoria = new Categoria($idUsuario, $descricaoCategoria);

    if($categoria->editarCategoria($id)){
        header("Location: ./categoria.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./categoria.php'><button>Retornar às Categorias</button></a></p>";
<?php
    include_once './../../classes/Usuario.php';
    include_once './../../classes/Entrada.php';
    include_once './../../classes/CategoriaEntrada.php';
    
    if(!isset($_GET['id'])){   
        header('Location: ./Entrada.php');
        die();
    }
     
    $id = $_GET['id'];
    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaEntrada'];

    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaEntrada = CategoriaEntrada::selectId($descricao);

    $entrada = new Entrada($idUsuario, $idCategoriaEntrada, $valor);
    
    if($entrada->editar_entrada($id)){
        header("Location: ./entrada.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./entrada.php'><button>Retornar</button></a></p>";
?>
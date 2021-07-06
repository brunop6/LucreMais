<?php
    include_once './../../classes/Usuario.php';
    include_once './../../classes/Recibo.php';
    include_once './../../classes/CategoriaRecibo.php';
    
    if(!isset($_GET['id'])){   
        header('Location: ./recibo.php');
        die();
    }
     
    $id = $_GET['id'];
    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaRecibo'];

    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaRecibo = CategoriaRecibo::selectId($descricao);

    $recibo = new Recibo($idUsuario, $idCategoriaRecibo, $valor);
    
    if($recibo->editar_recibo($id)){
        header("Location: ./recibo.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./recibo.php'><button>Retornar</button></a></p>";
?>
<?php
    include '../includes/conecta_bd.inc';
    include_once '../classes/Despesa.php';
    include_once '../classes/Usuario.php';
    include_once '../classes/CategoriaDespesa.php';
    if(!isset($_GET['id'])){   
        header('Location: ./despesa.php');
        die();
    }
     
    $id = $_GET['id'];
    $custo = $_POST['valor'];
    $descricao = $_POST['categoriaDespesa'];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaDespesa = CategoriaDespesa::selectId($descricao);

    $despesa = new Despesa($idUsuario, $idCategoriaDespesa, $custo);
    
    if($despesa->editar_despesa($id)){
        header("Location: ./despesa.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./despesa.php'><button>Retornar</button></a></p>";
?>
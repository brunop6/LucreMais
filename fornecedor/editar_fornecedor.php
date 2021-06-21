<?php
    include_once '../classes/Fornecedor.php';
    include_once '../classes/Usuario.php';

    if(!isset($_GET['id']) || !isset($_POST['nomeFornecedor']) || !isset($_POST['telefone'])){
        header('Location: fornecedor.php');
        die();
    }
    
    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $fornecedor = new Fornecedor($idUsuario, $nomeFornecedor, $email, $telefone, $cnpj, $endereco);

    if($fornecedor->editarFornecedor($id)){
        header("Location: ./fornecedor.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./fornecedor.php'><button>Retornar aos Fornecedores</button></a></p>";
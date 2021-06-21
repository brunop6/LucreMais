<?php
    define('menu', 'Fornecedores');
    include_once "../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="aparencia_fornecedor.css">
</head>
<body>
    <img src="./../Logo.png" alt="Logo do site" width="14%">
    <h1>Cadastro de Fornecedor<br></h1>

    <form action="cadastrar_fornecedor.php" method="POST">
        <p><input type="text" name="nomeFornecedor" placeholder="*Nome do Fornecedor*" id="em" required></p>
            
        <p><input type="email" name="email" placeholder="Email Fornecedor"></p>

        <p><input type="text" name="telefone" placeholder="*Telefone*" required></p>

        <p><input type="text" name="cnpj" placeholder="CNPJ"></p>

        <p><input type="text" name="endereco" placeholder="Endereço Fornecedor"></p>
           
        <p><input type="submit" value="Cadastrar Fornecedor"></p>
        
        <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
    </form>
</body>
</html>
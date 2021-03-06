<?php
    define('menu', 'Fornecedores');
    include_once "../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    
    include_once '../classes/Fornecedor.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        list($nomeFornecedor, $email, $telefone, $cnpj, $endereco) = Fornecedor::selectFornecedor($id);
    }else{
        header('Location: ./fornecedor.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./../public/js/datalists.js"></script>
    
    <link rel="icon" href="./../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../public/css/formStyle.css">

    <title>Edita Fornecedor</title>
</head>
<body>
<img src="./../public/img/Logo.png" alt="Logo do site" width="14%">
    <h1>Editar de Fornecedor<br></h1>
    <form action="editar_fornecedor.php?id=<?php echo $id ?>" method="POST">
        <p><input type="text" name="nomeFornecedor" id="fornecedor" value="<?php echo $nomeFornecedor ?>" placeholder="Nome do Fornecedor" list="fornecedores" oninput="preencherFornecedores()" required></p>
        <datalist id="fornecedores">
        
        </datalist>
        <p><input type="email" name="email" value="<?php echo $email ?>" placeholder="Email Fornecedor"> </p>

        <p><input type="text" name="telefone" value="<?php echo $telefone ?>" placeholder="Telefone" required></p>

        <p><input type="text" name="cnpj" value="<?php echo $cnpj ?>" placeholder="CNPJ"></p>

        <p><input type="text" name="endereco" value="<?php echo $endereco ?>" placeholder="Endereço Fornecedor"></p>
           
        <p><input type="submit" value="Salvar" name="Salvar Alterações"></p>
        
        <input type="button" value="Cancelar" onclick="window.location.href='./fornecedor.php'">
    </form>
</body>
</html>

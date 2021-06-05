<?php
    include 'includes/validacao_cookies.inc';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="Aparencia.css">
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastro_fornecedor/cadastro_fornecedor.php">Cadastrar fornecedor</a></li>
                <li><a href="./cadastro_item/cadastro_de_itens.php">Cadastrar itens</a></li>
                <li><a href="./estoque/estoque.php">Estoque</a></li>
                <li><a href="./Receitas/cadastrar_receitas.php">Receitas</a></li>
                <li><a href="logoff.php">Logoff</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
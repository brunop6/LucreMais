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
                <li><a href="./fornecedor/fornecedor.php">Fornecedores</a></li>
                <li><a href="./item/item.php">Itens</a></li>
                <li><a href="./estoque/estoque.php">Estoque</a></li>
                <li><a href="./Receitas/cadastrar_receitas.php">Receitas</a></li>
                <li><a href="logoff.php">Logoff</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
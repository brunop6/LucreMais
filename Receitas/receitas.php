<?php
    define('menu', 'Receitas');
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
    <link rel="stylesheet" href="./receitas.css">
    <title>Receitas</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastrar_receitas.php">Cadastrar Receita</a></li>
                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="receita" id="receita1">
            <h3><a href="visualizar_receita.php?id=1">PAÇOCA</a></h3>
            <p>Rendimento: 1300 GRAMAS</p>
            <p>Valor de venda: R$32.90</p>
        </div>
    </main>
</body>
</html>
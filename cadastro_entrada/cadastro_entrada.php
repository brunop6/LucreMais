<?php
define('menu', 'Financeiro');
include_once "../classes/Usuario.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

if (!Usuario::verificarMenu($idUsuario, menu)) {
    header("Location: ./../Home.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./cadastro_entrada.js"></script>
    <title>Entrada</title>
    <link rel="stylesheet" href="./../financeiro/entrada/entrada.css">
</head>

<body>
    <img src="./../Logo.png" alt="Logo do site" width="14%">

    <form action="cadastrar_entrada.php" method="POST">
        <h1>
            <p>Entradas <input type="text" name="categoriaEntrada" id="categoriaEntrada" list="categorias" oninput="preencherCategorias()" placeholder="Tipo de Entrada" required></p>
        </h1>
        <datalist id="categorias">

        </datalist>
        <input type="number" name="valor" min="0" step="0.01" placeholder="R$">

        <p><input type="submit" value="Confirmar"></p>
        <p><input type="button" value="Voltar" onclick="window.location.href='./../financeiro/entrada/entrada.php'"></p>
    </form>
</body>
</html>
<?php
define('menu', 'Financeiro');
include_once "../../../classes/Usuario.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

if (!Usuario::verificarMenu($idUsuario, menu)) {
    header("Location: ./../../../Home.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./cadastro_receitaFinanceiro.js"></script>
    <title>Receita F.</title>
    <link rel="stylesheet" href="./../receitaFinanceiro.css">
</head>

<body>
    <img src="./../../../public/img/Logo.png" alt="Logo do site" width="14%">

    <form action="cadastrar_receitaFinanceiro.php" method="POST">
        <h1>
            <p>Receitas <input type="text" name="categoriaReceita" id="categoriaReceita" list="categorias" oninput="preencherCategorias()" placeholder="Tipo de Receita" required></p>
        </h1>
        <datalist id="categorias">

        </datalist>
        <input type="number" name="valor" min="0" step="0.01" placeholder="R$">

        <p><input type="submit" value="Confirmar"></p>
        <p><input type="button" value="Voltar" onclick="window.location.href='./../receitaFinanceiro.php'"></p>
    </form>
</body>
</html>
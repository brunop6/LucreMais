<?php
    define('menu', 'Receitas');
    include_once "./../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <link rel="icon" href="./../../public/img/icone-LucreMais.png">

    <link rel="stylesheet" href="./../../public/css/headerMenu.css">
    <link rel="stylesheet" href="./../../public/css/tableStyle.css">
    <link rel="stylesheet" href="./../../public/css/inputs.css">
    
    <title>Receitas Realizadas</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        
        <nav class="menu">
            <ul>
                <li><a href="./../receitas.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Tabela de receitas realizadas / msg para nenhuma receita realizada -->
        <br>
        <button onclick="verMais()" class="btn-plus">Ver mais...</button>

        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Receita</th>
                <th class='mais'>Rendimento</th>
                <th class='mais'>Valor de venda</th>
                <th class='mais'>Data</th>
                <th class='mais'>Usuário</th>
                <th>Qnt. realizada</th>
                <th>Detalhar</th>
            </tr>
        </table>
    </main>

    <script type="text/javascript" src="./../../public/js/verMais.js"></script>
</body>
</html>
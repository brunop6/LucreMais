<?php
    define('menu', 'Receitas');
    include_once "../../classes/Usuario.php";

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
    <link rel="stylesheet" href="./../receitas.css">
    
    <title>Receita Paçoca</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="#">Habilitar Edição</a></li>
                <li><a href="./../receitas.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="view-receita">
            <h1>PAÇOCA</h1>
            <br>
            <h2>INGREDIENTES: </h2>
            <br>
            <ul>
                <li>AMENDOIM YOKI. . . . . . . . . . . . : 500g &#10142; R$7.00 Preco: 500g &#10142; R$7.00</li>
                <li>FARINHA MILHO MANTIQUEIRA: 500g &#10142; R$2.99    Preco: 500g  &#10142; R$2.99</li>
                <li>AÇÚCAR CRISTAL UNIÃO. . . . . .: 300g &#10142; R$0.71    Preco: 1000g &#10142; R$2.36</li>
                <br>
                <h2>EMBALAGENS: </h2>
                <br>
                <li>POTE PLÁSTICO SANTISTA: 1 UNIDADE(2) &#10142; R$7.90    Preco: 1 UNIDADE(S) &#10142; R$7.90</li>
            </ul>
            
            <br>
            <p><b>Total: R$ 18.60</b></p>
            <p><b>Rendimento: 1300 GRAMAS</b></p>
            <br>
            <h3>Lucros Totais: </h3>
            <p><b>150%: R$34.65</b></p>
            <p><b>100%: R$29.30</b></p>
            <br>
            <h3>Valor de venda: R$32.90</h3>
            <h3>Previsão de lucro: R$14.30 &#10142; 133.69%</h3>
        </div>
        <aside>
            <form action="" method="POST">
                <input type="submit" value="Realizar Receita">
                <input type="number" name="quantidade" value="0" min="0">
            </form>
        </aside>
    </main>
</body>
</html>
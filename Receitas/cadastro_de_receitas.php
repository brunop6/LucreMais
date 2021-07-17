<?php
    define('menu', 'Receitas');
    include_once "../classes/Usuario.php";
    include_once '../classes/Item.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    list($marca, $nome) = Item::selectItens($emailUsuario);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar receita</title>
    <script type="text/javascript" src="./criacampo.js"></script>
    <link rel="stylesheet" href="./../cadastro_item/aparenciaitem.css">
</head>
<body>
    <h1 style="color: #B9DEFF;">Cadastro de Receitas<br></h1>

    <form action="cadastrar_receitas.php" method="POST" id="formulario">
        <!--Parágrafo invisível para controle do número de ingredientes-->
        <p id="numIngred" hidden>1</p>

        <p><input type="submit" value="Cadastrar Receita" id="cadastrar"></p><br>
        <p><input type="text" name="nomeReceita" placeholder="Nome da receita" required></p>
        <p><input type="text" name="ingrediente1" placeholder="1° Ingrediente" required></p>
        <p><input type="number" name="quantidade1" placeholder="Quantidade" required></p>
        <select id="unidade_de_medida" name = "unidade_de_medida1" >
            <option value="unidade_de_medida">Unidade de Medida</option> 
            <option value="unidade(s)">Unidade</option>
            <option value="ml">ML</option>
            <option value="gramas">Grama</option>
            <option value="colher_de_sopa">Colher de Sopa</option>
            <option value="colher_de_cha">Colher de Chá</option>
            <option value="colher_de_cafe">Colher de Café</option>
            <option value="xicara">Xícara</opition>
            <option value="quilo(s)">Quilo(s)</option>
        </select>
        <p><button id="inserir" onclick="inseriringrediente()">Inserir ingrediente</button></p>
    </form>
</body>
</html>
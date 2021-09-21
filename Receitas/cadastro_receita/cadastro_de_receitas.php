<?php
    define('menu', 'Receitas');
    include_once "../../classes/Usuario.php";
    include_once '../../classes/Item.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
    list($marca, $nome) = Item::selectItens($emailUsuario);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./criacampo.js"></script>
    <script type="text/javascript" src="./../../public/js/datalists.js"></script>

    <link rel="icon" href="./../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../public/css/formStyle.css">
    
    <title>Cadastrar receita</title>
</head>
<body>
    <img src="./../../public/img/Logo.png" alt="Logo do site" width="14%">
    <h1 style="color: #B9DEFF;">Cadastro de Receitas<br></h1>

    <form action="cadastrar_receitas.php" method="POST" id="formulario">
        <!-- Datalist único que fornece os dados para todos os input #item -->
        <datalist id="itens">
        </datalist>

        <!--Parágrafo invisível para controle do número de ingredientes-->
        <p id="numIngred" hidden>1</p>

        <p><input type="submit" value="Cadastrar Receita" id="cadastrar"></p>
        
        <p><input type="text" name="nomeReceita" placeholder="Nome da receita" required></p>
        
        <p><input type="text" name="rendimento" placeholder="Rendimento" required></p>

        <select name = "unidadeMedida" >
            <option value="unidade_de_medida">Unidade de Medida</option> 
            <option value="unidade(s)">Unidade</option>
            <option value="ml">ML</option>
            <option value="gramas">Grama</option>
            <option value="quilos(s)">Quilo(s)</option>
            <option value="litro(s)">Litro(s)</option>
        </select>
        
        <p><input type="number" step="0.01" name="valorVenda" placeholder="Valor de venda" required></p>

        <p><input type="text" name="ingrediente1" placeholder="1° Ingrediente" oninput="preencherItens()" id="item" list="itens" required></p>
        
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

        <label id="sugestao-preco"></label>
        
        <p><button id="inserir" onclick="inseriringrediente()">Inserir ingrediente</button></p>
    </form>
</body>
</html>
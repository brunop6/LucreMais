<?php
include "../includes/conecta_bd.inc";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Itens</title>
    <link rel="stylesheet" href="aparenciaitem.css">
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">
            <h1>Cadastrar Itens<br></h1>
            <p><input type="text" name="nome" placeholder="Nome do Item" id="em"></p>
            
            <p><input type="text" name="quantidade" placeholder="Quantidade"></p>

            <select id="unidade_de_medida" >
            <option value="unidade_de_medida">Unidade de Medida</opition> 
            <option value="ml">ML</opition>
            <option value="grama">Grama</opition>
            <option value="colher_de_sopa">Colher de Sopa</opition>
            <option value="colher_de_cha">Colher de Chá</opition>
            <option value="colher_de_cafe">Colher de Café</opition>
            <option value="xicara">Xícara</opition>
            </select>

            <p><input type="text" name="preco" placeholder="Preço"></p>

            <p><input type="text" name="lote" placeholder="Lote"></p>

              <p>Status:</p>
                <input type="checkbox" name="ativo" value="ativo">Ativo</input><br>
                <input type="checkbox" name="inativo" value="inativo">Inativo</input>
           
            <p><a href="../Estoque/estoque_interface.php"><input type="submit" value="Cadastrar Item"> <br>
            <a href="../."><input type="submit" value="Voltar">
            
</html>
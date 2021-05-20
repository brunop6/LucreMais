<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar receita</title>
    <script type="text/javascript" src="./criacampo.js"></script>
</head>
<body>
    <h1>Cadastro de Receitas<br></h1>

    <form action="" method="POST" id="formulario">
    <p><input type="submit" value="Cadastrar Receita" id="cadastrar"></p><br>
    <p><input type="text" name="nomeReceita" placeholder="Nome da receita"></p>
    <p><input type="text" name="ingrediente" placeholder="Ingrediente"></p>
    <p><input type="number" name="quantidade" placeholder="Quantidade"></p>
    <select id="unidade_de_medida" >
        <option value="unidade_de_medida">Unidade de Medida</option> 
        <option value="ml">ML</option>
        <option value="grama">Grama</option>
        <option value="colher_de_sopa">Colher de Sopa</option>
        <option value="colher_de_cha">Colher de Chá</option>
        <option value="colher_de_cafe">Colher de Café</option>
        <option value="xicara">Xícara</opition>
    </select>
    <p><button id="inserir" onclick="inseriringrediente()">Inserir ingrediente</button></p>
    </form>
</body>
</html>
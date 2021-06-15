<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edição de item</title>
</head>
<body>
    <img src="../Logo.png" alt="Logo do site" width="14%">
    <form action="" method="POST">
        <h3>Marca: </h3>
        <p><input type="text" name="marca" list="marcas" required></p>
        <datalist id="marcas">
        </datalist>
        <h3>Nome: </h3>
        <p><input type="text" name="nome" list="nomes" required></p>
        <datalist id="nomes">
        </datalist>
        <h3>Categoria</h3>
        <p><input type="text" name="categoria" list="categorias" required></p>
        <datalist id="categorias">
        </datalist>
        <h3>Quantidade: </h3>
        <p><input type="number" name="quantidade" step="0.1" required></p>
        <h3>Quantidade mínima: </h3>
        <p><input type="number" name="quantidade minima" step="0.1" required></p>
        <h3>Unidade de medida: </h3>
        <select name="unidade_de_medida" id="unidadeMedida" required>
            <option value="unidade_de_medida">Unidade de Medida</option>
            <option value="unidade(s)">Unidade(s)</option>
            <option value="litro(s)">Litro(s)</option> 
            <option value="ml">ml</option>
            <option value="gramas">Gramas</option>
            <option value="colher_de_sopa" >Colher de Sopa</option>
            <option value="colher_de_cha" >Colher de Chá</option>
            <option value="colher_de_cafe">Colher de Café</option>
            <option value="xicara">Xícara</option>
        </select>
        <p>
            <input type="submit" value="Salvar" name="salvar">
            <input type="button" value="Cancelar" onclick="window.location.href='./item.php'">
        </p>
    </form>
</body>
</html>
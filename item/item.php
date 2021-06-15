<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estoque/estoque.css">
    <title>Estoque</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="../cadastro_item/cadastro_de_itens.php">Cadastrar itens</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Quantidade mínima</th>
                <th>Data de cadastro</th>
                <th>Data de atualização</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>
        </table>
    </main>
</body>
</html>
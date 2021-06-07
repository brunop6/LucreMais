<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estoque.css">
    <title>Document</title>
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">
<header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="">Lista de Compras</a>
                    <ul>
                        <li><a href="./listaCompras/lista_compras.php">Visualizar no navegador</a></li>
                        <li><a href="./listaCompras/lista_compras_pdf.php">Visualizar em PDF</a></li>
                    </ul>
                </li>

                <li><a href=".././Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>

        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
                <th>Un. Medida</th>
                <th>Preço</th>
                <th>Quant. Mínima</th>
                <th>Lote</th>
            </tr>
           
        </table>
    


</body>
</html>
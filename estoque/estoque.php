<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Aparencia.css">
    <title>Estoque</title>
    <style>
        table, th, td {
            border: 2px solid black;
            border-collapse: collapse;

            background-color: white;
        }
    </style>
    <?php
        function preencherEstoque(){
            include_once '../classes/Estoque.php';

            list($nomeItem, $marca, $categoria, $fornecedor, $quantidadeEstoque, $unidadeMedida, $preco, $quantidadeItem, $lote, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Estoque::retornar_itens_estoque('1');

            $i = 0;
            foreach($nomeItem as $nome){
                echo "<tr>";

                echo "<td>$nome</td>";
                echo "<td>$quantidade[$i]</td>";
                echo "<td>$unidadeMedida[$i]</td>";
                echo "<td>$preco[$i]</td>";
                echo "<td>$lote[$i]</td>";

                echo "</tr>";
                $i++;
            }
        }
    ?>
</head>
<body>
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

                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table style="width:100%; margin-top: 10px">
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
                <th>Un. Medida</th>
                <th>Preço</th>
                <th>Quant. Mínima</th>
                <th>Lote</th>
            </tr>
            <?php
                preencherEstoque();
            ?>
        </table>
    </main>
</body>
</html>
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

                echo "<td>$nome $marca[$i]</td>";
                echo "<td>$categoria[$i]</td>";
                echo "<td>$fornecedor[$i]</td>";
                echo "<td>$quantidadeEstoque[$i] $unidadeMedida[$i]</td>";
                echo "<td>R$ $preco[$i]</td>";
                echo "<td>$quantidadeItem[$i] $unidadeMedida[$i]</td>";
                echo "<td>$lote[$i]</td>";
                echo "<td>$dataCadastro[$i]</td>";
                echo "<td>$dataAtualizacao[$i]</td>";
                echo "<td>$nomeUsuario[$i]</td>";

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
                <li><a href="../cadastro_estoque/cadastro_estoque.php">Cadastrar Estoque</a></li>
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
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Quant. Estoque</th>
                <th>Preço</th>
                <th>Quant. Item</th>
                <th>Lote</th>
                <th>Data Cadastro</th>
                <th>Data Atualização</th>
                <th>Usuário</th>
            </tr>
            <?php
                preencherEstoque();
            ?>
        </table>
    </main>
</body>
</html>
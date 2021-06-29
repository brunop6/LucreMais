<?php
    define('menu', 'Estoque');
    include_once "../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./estoque.css">
    <title>Estoque</title>
    <?php
        if(isset($_GET['status'])){
            $status = $_GET['status'];
        }else{
            $status = 1;
        }

        function preencherEstoque($status){
            include_once '../classes/Estoque.php';

            list($id, $nomeItem, $marca, $categoria, $fornecedor, $quantidadeEstoque, $unidadeMedida, $preco, $quantidadeItem, $lote, $validade, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Estoque::retornar_itens_estoque($status);

            if(!empty($nomeItem)){
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
                    echo "<td>$validade[$i]</td>";
                    echo "<td>$dataCadastro[$i]</td>";
                    echo "<td>$dataAtualizacao[$i]</td>";
                    echo "<td>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_estoque.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                    echo "</tr>";
                    $i++;
                }
            }
        }
    ?>
    <script>
        function alterarExibicao(){
            var status = document.getElementById('status').value;

            window.location.href = "?status="+status;
        }
    </script>
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
        <select id="status" onchange="alterarExibicao()">
            <?php
                if($status == 1){
                    echo "
                    <option value='1'>Ativos</option>
                    <option value='0'>Inativos</option>
                    ";
                }else{
                    echo "
                    <option value='0'>Inativos</option>
                    <option value='1'>Ativos</option>
                    ";
                }
            ?>
        </select>

        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Item</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Quant. Estoque</th>
                <th>Preço</th>
                <th>Quant. Item</th>
                <th>Lote</th>
                <th>Validade</th>
                <th>Data Cadastro</th>
                <th>Data Atualização</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>
            <?php
                preencherEstoque($status);
            ?>
        </table>
    </main>
</body>
</html>
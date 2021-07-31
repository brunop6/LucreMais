<?php
define('menu', 'Estoque');
include_once "../classes/Usuario.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$idUsuario = $_SESSION['id_usuario'];
$email = $_SESSION['email_usuario'];

if (!Usuario::verificarMenu($idUsuario, menu)) {
    header("Location: ./../Home.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="./estoque.js"></script>
    <link rel="stylesheet" href="./estoque.css">
    <title>Estoque</title>
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    } else {
        $status = 1;
    }
    if (isset($_GET['marca'])) {
        $marca = $_GET['marca'];
    } else {
        $marca = null;
    }
    if (isset($_GET['nome'])) {
        $nome = $_GET['nome'];
    } else {
        $nome = null;
    }
    if (isset($_GET['categoria'])) {
        $categoria = $_GET['categoria'];
    } else {
        $categoria = null;
    }
    if (isset($_GET['lote'])) {
        $lote = $_GET['lote'];
    } else {
        $lote = null;
    }
    function preencherEstoque($status, $marca, $nome, $categoria, $lote)
    {
        global $email;
        include_once '../classes/Estoque.php';

        list($id, $nomeItem, $marca, $categoria, $fornecedor, $quantidadeEstoque, $unidadeMedida, $preco, $quantidadeItem, $lote, $validade, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Estoque::retornar_itens_estoque_filtro($status, $marca, $nome, $categoria, $lote, $email);

        if (!empty($nomeItem)) {
            $i = 0;
            foreach ($nomeItem as $nome) {
                echo "<tr>";

                echo "<td>$nome $marca[$i]</td>";
                echo "<td>$categoria[$i]</td>";
                echo "<td>$fornecedor[$i]</td>";
                echo "<td>$quantidadeEstoque[$i] $unidadeMedida[$i]</td>";
                echo "<td>R$ $preco[$i]</td>";
                echo "<td>$quantidadeItem[$i] $unidadeMedida[$i]</td>";
                echo "<td class='mais'>$lote[$i]</td>";
                echo "<td class='mais'>$validade[$i]</td>";
                echo "<td class='mais'>$dataCadastro[$i]</td>";
                echo "<td class='mais'>$dataAtualizacao[$i]</td>";
                echo "<td class='mais'>$nomeUsuario[$i]</td>";
                echo "<td><a href='./edita_estoque.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                echo "</tr>";
                $i++;
            }
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
        <div class="filtros">
            <select id="status" onchange="alterarExibicao()">
                <?php
                if ($status == 1) {
                    echo "
                    <option value='1'>Ativos</option>
                    <option value='0'>Inativos</option>
                    ";
                } else {
                    echo "
                    <option value='0'>Inativos</option>
                    <option value='1'>Ativos</option>
                    ";
                }
                ?>
            </select>
            <input type="text" id="nome" placeholder="Nome" value="<?php if(isset($_GET['nome'])) echo $_GET['nome']; ?>">
            <input type="text" id="marca" placeholder="Marca" value="<?php if(isset($_GET['marca'])) echo $_GET['marca']; ?>">
            <input type="text" id="categoria" placeholder="Categoria" value="<?php if(isset($_GET['categoria'])) echo $_GET['categoria']; ?>">
            <input type="number" id="lote" min="0" placeholder="Lote" value="<?php if(isset($_GET['lote'])) echo $_GET['lote']; ?>">
            <button onclick="alterarExibicao()">Buscar</button>
            <button onclick="verMais()" class="btn-plus">Ver mais...</button>
        </div>
        
        <table style="width:100%; margin-top: 10px" ; border="1px">
            <tr>
                <th>Item</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Quant. Estoque</th>
                <th>Preço</th>
                <th>Quant. Item</th>
                <th class="mais">Lote</th>
                <th class="mais">Validade</th>
                <th class="mais">Data Cadastro</th>
                <th class="mais">Data Atualização</th>
                <th class="mais">Usuário</th>
                <th>Editar</th>
            </tr>
            <?php
            preencherEstoque($status, $marca, $nome, $categoria, $lote);
            ?>
        </table>
        <script type="text/javascript" src="./../public/js/verMais.js"></script>
    </main>
</body>

</html>
<?php
    define('menu', 'Itens');
    include_once "../../classes/Usuario.php";

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
    <title>Categoria Despesa</title>
    <link rel="stylesheet" href="../../estoque/estoque.css">
    <?php
        function preencherCategorias(){
            include_once '../../classes/CategoriaDespesa.php';

            list($id, $descricao, $dataCadastro, $dataAtualizacao, $nomeUsuario) = CategoriaDespesa::selectCategorias();

            if(!empty($descricao)){
                $i = 0;
                foreach($id as $index){
                    echo '<tr>';

                    echo "<td>$index</td>";
                    echo "<td>$descricao[$i]</td>";
                    echo "<td>$dataCadastro[$i]</td>";
                    echo "<td>$dataAtualizacao[$i]</td>";
                    echo "<td>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_categoria.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                    echo '</tr>';
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
                <li><a href="../despesa.php">Voltar</a></li>
                <li><a href="../../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data de cadastro</th>
                <th>Data de atualização</th>
                <th>Usuário</th>
                <th>Editar</th>
                <?php
                    preencherCategorias();
                ?>
            </tr>
        </table>
    </main>
</body>
</html>
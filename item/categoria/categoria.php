<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Categoria</title>
    <link rel="stylesheet" href="../../estoque/estoque.css">
    <?php
        function preencherCategorias(){
            include_once '../../classes/Categoria.php';

            list($id, $descricao, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Categoria::selectCategorias();

            if(!empty($descricao)){
                $i = 0;
                foreach($id as $index){
                    echo '<tr>';

                    echo "<td>$index</td>";
                    echo "<td>$descricao[$i]</td>";
                    echo "<td>$dataCadastro[$i]</td>";
                    echo "<td>$dataAtualizacao[$i]</td>";
                    echo "<td>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_categoria.php?id=$id[$i]' style='color:rgb(173,144,0)'>Editar</a></td>";

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
                <li><a href="../item.php">Voltar</a></li>
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
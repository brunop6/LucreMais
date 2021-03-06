<?php
    define('menu', 'Financeiro');
    include_once "./../../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $email = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: /LucreMais/Home.php");
        die();
    }

    function preencherCategorias(){
        global $email;
        include_once './../../../classes/CategoriaReceitaFinanceiro.php';

        list($id, $descricao, $dataCadastro, $dataAtualizacao, $nomeUsuario) = CategoriaReceitaFinanceiro::selectCategorias($email);

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
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <link rel="icon" href="./../../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../../public/css/headerMenu.css">
    <link rel="stylesheet" href="./../../../public/css/tableStyle.css">
    
    <title>Categorias Receita</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="/LucreMais/Home.php">Página Principal</a></li>
                <li><a href="../receitaFinanceiro.php">Voltar</a></li>
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
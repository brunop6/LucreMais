<?php
    define('menu', 'Financeiro');
    include_once "../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $email = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ../../Home.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./receitaFinanceiro.css">
    <title>Receita F.</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="../../cadastro_receitaFinanceiro/cadastro_receitaFinanceiro.php">Cadastrar receita</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../financeiro.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            include_once '../../classes/ReceitaFinanceiro.php';
            include_once '../../classes/CategoriaReceitaFinanceiro.php';
        
            function preencherReceitas(){
                global $email;
                list($id, $descricao, $custo, $nomeUsuario) = ReceitaFinanceiro::selectReceitaLista($email);
                if(!empty($descricao)){
                    $i = 0;
                    foreach($descricao as $descricao){
                        echo "<tr>";
                    
                        echo "<td>$descricao</td>";
                        echo "<td>R$ $custo[$i]";
                        echo "<td>$nomeUsuario[$i]</td>";
                        echo "<td><a href='./edita_receitaFinanceiro.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                }
            }

            $totalMensal = ReceitaFinanceiro::selectTotal($email);
        ?>
 
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
                <th>Receita</th>
                <th>Valor</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>     
            <?php   
                preencherReceitas();
            ?>
        </table>
        <br>
        <h3>Total mensal: <?php echo "R$ ".number_format($totalMensal, 2) ?></h3>
    </main>
</body>
</html>
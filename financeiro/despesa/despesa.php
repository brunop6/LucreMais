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
    <link rel="stylesheet" href="./despesa.css">
    <title>Despesa</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastro_despesa/cadastro_de_despesa.php">Cadastrar despesa</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../financeiro.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            include_once '../../classes/Despesa.php';
            include_once '../../classes/CategoriaDespesa.php';
        
            function preencherDespesa(){
                global $email;
                list($id, $descricao, $custo, $nomeUsuario) = Despesa::selectDespesasMes($email);
                if(!empty($descricao)){
                    $i = 0;
                    foreach($descricao as $descricao){
                        echo "<tr>";
                    
                        echo "<td>$descricao</td>";
                        echo "<td>R$ $custo[$i]";
                        echo "<td>$nomeUsuario[$i]</td>";
                        echo "<td><a href='./edita_despesa.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                }
            }

            $totalMensal = Despesa::selectTotalMes($email);
        ?>
 
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
                <th>Despesa</th>
                <th>Custo</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>     
            <?php   
                preencherDespesa();
            ?>
        </table>
        <br>
        <h3>Total mensal: <?php echo "-R$ ".number_format($totalMensal, 2);?></h3>
    </main>
</body>
</html>
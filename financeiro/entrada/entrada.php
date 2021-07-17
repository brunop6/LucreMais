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
    <link rel="stylesheet" href="./entrada.css">
    <title>Despesa</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="../../cadastro_entrada/cadastro_entrada.php">Cadastrar entrada</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../financeiro.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            include_once '../../classes/Entrada.php';
            include_once '../../classes/CategoriaEntrada.php';
        
            function preencherEntradas(){
                global $email;
                list($id, $descricao, $custo, $nomeUsuario) = Entrada::selectEntradaLista($email);
                if(!empty($descricao)){
                    $i = 0;
                    foreach($descricao as $descricao){
                        echo "<tr>";
                    
                        echo "<td>$descricao</td>";
                        echo "<td>R$ $custo[$i]";
                        echo "<td>$nomeUsuario[$i]</td>";
                        echo "<td><a href='./edita_entrada.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                }
            }

            $totalMensal = Entrada::selectTotal($email);
        ?>
 
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
                <th>Entrada</th>
                <th>Valor</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>     
            <?php   
                preencherEntradas();
            ?>
        </table>
        <br>
        <h3>Total mensal: <?php echo "R$ ".number_format($totalMensal, 2) ?></h3>
    </main>
</body>
</html>
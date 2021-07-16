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
    <link rel="stylesheet" href="./recibo.css">
    <title>Despesa</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="../../cadastro_recibo/cadastro_recibo.php">Cadastrar recibo</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../financeiro.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            include_once '../../classes/Recibo.php';
            include_once '../../classes/CategoriaRecibo.php';
        
            function preencherRecibo(){
                global $email;
                list($id, $descricao, $custo, $nomeUsuario) = Recibo::selectReciboLista($email);
                if(!empty($descricao)){
                    $i = 0;
                    foreach($descricao as $descricao){
                        echo "<tr>";
                    
                        echo "<td>$descricao</td>";
                        echo "<td>R$ $custo[$i]";
                        echo "<td>$nomeUsuario[$i]</td>";
                        echo "<td><a href='./edita_recibo.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                }
            }

            $totalMensal = Recibo::selectTotal($email);
        ?>
 
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
                <th>Recibo</th>
                <th>Valor</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>     
            <?php   
                preencherRecibo();
            ?>
        </table>
        <br>
        <h3>Total mensal: <?php echo "R$ $totalMensal" ?></h3>
    </main>
</body>
</html>
<?php
    define('menu', 'Financeiro');
    include_once "../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $email = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }

    include_once './../classes/Despesa.php';
    include_once './../classes/Recibo.php';

    $despesaMensal = Despesa::selectTotal($email);
    $entradaMensal = Recibo::selectTotal($email);

    $porcentagemLucro = (($entradaMensal-$despesaMensal)*100)/$despesaMensal;
    $lucroReal = $entradaMensal - $despesaMensal;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../Aparencia.css">
    <link rel="stylesheet" href="./financeiro.css">
    <title>Financeiro</title>
</head>
<body>
<header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./recibo/recibo.php">Recibos</a></li> 
                <li><a href="./despesa/despesa.php">Despesas</a></li>          
                <li><a href="./../Home.php">Voltar</a></li>          
            </ul>
        </nav>
    </header>
    <div class="lucro">
        <h3>Entrada mensal: <span class="entrada"><?php echo "R$ $entradaMensal" ?></span></h3>
        <h3>Despesa mensal: <span class="despesa"><?php echo "R$ $despesaMensal" ?></span></h3>
        <br>
        <h3>Lucro mensal: <?php echo "R$ $lucroReal &#10140; $porcentagemLucro%" ?></h3>
    </div>
</body>
</html>
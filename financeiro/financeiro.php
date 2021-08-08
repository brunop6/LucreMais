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
    include_once './../classes/ReceitaFinanceiro.php';

    $despesaMensal = Despesa::selectTotalMes($email);
    $receitaMensal = ReceitaFinanceiro::selectTotalMes($email);

    if($despesaMensal == 0 || $receitaMensal == 0){
        $porcentagemLucro = 0;
        $lucroReal = $receitaMensal;
    }else{
        $porcentagemLucro = (($receitaMensal-$despesaMensal)*100)/$despesaMensal;
        $lucroReal = $receitaMensal - $despesaMensal;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../public/css/headerMenu.css">
    <link rel="stylesheet" href="./financeiro.css">
    
    <title>Financeiro</title>
</head>
<body>
    <header>
        <p hidden id="email-usuario"><?php echo $email; ?></p>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./receita/receitaFinanceiro.php">Receitas</a></li> 
                <li><a href="./despesa/despesa.php">Despesas</a></li>          
                <li><a href="./../Home.php">Voltar</a></li>          
            </ul>
        </nav>
    </header>
    
    <div class="lucro">
        <h3>Receita atual: <span class="receita"><?php echo "R$ ".number_format($receitaMensal, 2); ?></span></h3>
        <h3>Despesa atual: <span class="despesa"><?php echo "R$ ".number_format($despesaMensal, 2); ?></span></h3>        
        <h3>
            <?php 
                if($porcentagemLucro){
                    echo 'Lucro: '.number_format($porcentagemLucro, 2)."%";
                }
            ?>
        </h3>
    </div>
    
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="./../public/js/monthConverter.js"></script>
    <script type="text/javascript" src="./grafico_financeiro.js"></script>
</body>
</html>
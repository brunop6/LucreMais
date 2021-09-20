<?php
    define('menu', 'Receitas');
    include_once "./../classes/Usuario.php";
    include_once "./../classes/Receita.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    
    list($idReceitas, $nomeReceitas, $rendimento, $unidadeMedida, $valorVenda) = Receita::selectReceitas($emailUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <link rel="icon" href="./../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../public/css/headerMenu.css">
    <link rel="stylesheet" href="./receitas.css">
    
    <title>Receitas</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastro_receita/cadastro_de_receitas.php">Cadastrar Receita</a></li>
                <li><a href="./receitas_realizadas/receitas_realizadas.php">Receitas Realizadas</a></li>
                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="receita">
            <h3><a href="./visualizar_receita/prototipo_visualizarReceita.php">PAÇOCA</a></h3>
            <p>Rendimento: 1300 GRAMAS</p>
            <p>Valor de venda: R$ 32.90</p>
        </div>
        <?php
            if(!empty($idReceitas)){
                $i = 0;
                foreach($idReceitas as $id){
                    echo "
                    <div class='receita'>
                        <h3><a href='./visualizar_receita/visualizarReceita.php?id=$id'>$nomeReceitas[$i]</a></h3>
                        <p>Rendimento: $rendimento[$i] $unidadeMedida[$i]</p>
                        <p>Valor de venda: R$ $valorVenda[$i]</p>
                    </div>";
                    $i++;
                }
            }
        ?>
    </main>
</body>
</html>
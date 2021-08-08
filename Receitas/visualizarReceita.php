<?php
    define('menu', 'Receitas');
    include_once "./../classes/Usuario.php";
    include_once "./../classes/Receita.php";
    include_once "./../classes/Item.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    if(!isset($_GET['id'])){
        header("Location: ./receitas.php");
        die();
    }
    $idReceita = $_GET['id'];

    list($nomeReceita, $idItem, $quantidadeReceita, $unidadeReceita, $custo) = Receita::infoReceita($idReceita);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="./../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../public/css/headerMenu.css">
    <link rel="stylesheet" href="./receitas.css">

    <title>Ver Receita</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastro_de_receitas.php">Habilitar Edição</a></li>
                <li><a href="./receitas.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="view-receita">
            <h1><?php echo $nomeReceita?></h1>
            <br>
            <h2>ITENS: </h2>
            <br>
            <ul>
                <?php
                    $i = 0;
                    $custoReceita = 0;
                    foreach($idItem as $id){
                        $custoReceita += $custo[$i];
                        list($nomeItem, $marca, $quantidadeItem, $unidadeItem, $descricaoCategoria) = Item::selectItemLista($id);
                        
                        echo "<li><b>$nomeItem $marca:</b> $quantidadeReceita[$i] $unidadeReceita[$i] &#10142; R$ $custo[$i]</li>";
                        $i++;
                    }
                ?>
            </ul>
            <br>
            <p><b>Custo: R$ <?php echo number_format($custoReceita, 2) ?></b></p>
        </div>

        <aside>
            <form action="" method="POST">
                <input type="submit" value="Realizar Receita">
                <input type="number" name="quantidade" value="0" min="0">
            </form>
        </aside>
    </main>
</body>
</html>
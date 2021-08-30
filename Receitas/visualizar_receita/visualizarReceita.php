<?php
    define('menu', 'Receitas');
    include_once "./../../classes/Usuario.php";
    include_once "./../../classes/Receita.php";
    include_once "./../../classes/Item.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
    if(!isset($_GET['id'])){
        header("Location: ./../receitas.php");
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

    <script src="https://kit.fontawesome.com/9c542dcfdc.js" crossorigin="anonymous"></script>
    
    <link rel="icon" href="./../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../public/css/headerMenu.css">
    <link rel="stylesheet" href="./../receitas.css">

    <title>Ver Receita</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="#">Habilitar Edição</a></li>
                <li><a href="./../receitas.php">Voltar</a></li>
            </ul>
        </nav>
    </header>
    <main class="view">
        <div class="view-receita">
            <h1><?php echo $nomeReceita?></h1>
            <br>
            <h2>ITENS: </h2>
            <br>
            <ul>
                <?php
                    $i = 0;
                    $custoReceita = 0;
                    $numMaximoReceitas = false;
                    foreach($idItem as $id){
                        $custoReceita += $custo[$i];
                        list($nomeItem, $marca, $quantidadeItem, $unidadeItem, $descricaoCategoria) = Item::selectItemLista($id);
                        
                        //Nº máximo de receitas permitida pelo item
                        $numReceitasItem = Receita::selectMaxReceitas($id, $quantidadeReceita[$i], $unidadeReceita[$i], $emailUsuario);

                        //Nº de receitas limitado pelo item com menor disponibilidade
                        if($numMaximoReceitas === false || $numReceitasItem < $numMaximoReceitas || $numReceitasItem == null){
                            $numMaximoReceitas = $numReceitasItem;
                            $itemLimitante = "$nomeItem $marca";
                        }

                        echo "<li><b>$nomeItem $marca:</b> $quantidadeReceita[$i] $unidadeReceita[$i] &#10142; R$ $custo[$i]</li>";
                        $i++;
                    }

                    $custoTotal = $custoReceita + $custoReceita * 0.3;
                ?>
            </ul>
            <br>
            <p><b>Custo: R$ <?php echo number_format($custoReceita, 2)." + 30% &#10142; R$ ". number_format($custoTotal, 2) ?></b></p>
        </div>
        <aside>
            <details>
                <summary id="info"><i class="fas fa-info-circle"></i></summary>
                <ul>
                    <li>
                        <b>Item limitante:</b> 
                        <br>
                        <?php echo " $itemLimitante"?>
                    </li>
                    <br>

                    <?php
                        if(!empty($numMaximoReceitas)){
                            echo "<li><b>Máx. de receitas: </b>$numMaximoReceitas</li>";
                        }else{
                            $numMaximoReceitas = 0;
                            echo "<li>Item em falta no estoque!</li>";
                        }
                    ?>   
                </ul>
            </details>
            <br>
            <form action="./../realizar_receita/realizarReceita.php?id=<?php echo $idReceita?>" method="POST">
                <input type="submit" value="Realizar Receita">
                <input type="number" name="quantidade" value="0" min="1" max="<?php echo $numMaximoReceitas?>">
            </form>
        </aside>
    </main>
</body>
</html>
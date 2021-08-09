<?php
    define('menu', 'Receitas');
    include_once './../../classes/Usuario.php';
    include_once './../../classes/Receita.php';
    include_once './../../classes/Receita_Item.php';
    include_once './../../classes/Estoque.php';
    include_once './../../classes/Item.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu) || !isset($_POST['quantidade']) || !isset($_GET['id'])){
        header("Location: ./../../Home.php");
        die();
    }

    $idReceita = $_GET['id'];
    $numReceitas = $_POST['quantidade'];

    //Dados da receita
    list($idItem, $quantidadeRec, $unidadeMedidaRec) = Receita_Item::selectReceita_Itens($idReceita);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../public/css/inputs.css">

    <title>Realização de Receita</title>
</head>
<body>
    <?php
        for($baixas = 0; $baixas < $numReceitas; $baixas++){
            $i = 0;
            foreach($idItem as $item){
                $unidadeMedidaRec[$i] = str_replace(' ', '_', $unidadeMedidaRec[$i]);
                
                //Quantidade usada por lote convertida p/ unidade de medida do item
                list($idEstoque, $quantUsadaLote) = Receita_Item::selectQuantidadeLote($item, $unidadeMedidaRec[$i], $quantidadeRec[$i]);

                $j = 0;
                foreach($quantUsadaLote as $quantidade){  
                    $resultado = Estoque::registrarBaixa($idEstoque[$j], $idUsuario, $quantidade);

                    if(!$resultado){
                        echo "<h2>$resultado</h2>";
                        echo "<button onclick='window.location.href='./../visualizar_receita/visualizarReceita.php?id=$idReceita''>Retornar à receita</button>";
                        break 3;
                    }
                    $j++;
                }
                $i++;
            }
        }
        
        if($resultado){
            echo "<h2>Receita realizada com sucesso!</h2>";
            echo "<button onclick='window.location.href='./../receitas.php''>Retornar às receitas</button>";
            echo "<button onclick='window.location.href='./../../Home.php''>Retornar à home</button>";
        }
    ?>
</body>
</html>
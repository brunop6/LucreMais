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
    
    if($_POST['quantidade'] <= 0){
        header("Location: ./../visualizar_receita/visualizarReceita.php?id=$idReceita");
        die();
    }

    $numReceitas = $_POST['quantidade'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../public/css/formStyle.css">

    <title>Realização de Receita</title>
</head>
<body>
    <?php
        for($baixas = 0; $baixas < $numReceitas; $baixas++){
            //Dados da receita
            list($idReceitaItem, $idItem, $quantidadeRec, $unidadeMedidaRec) = Receita_Item::selectReceita_Itens($idReceita);

            $i = 0;
            foreach($idItem as $item){
                $unidadeMedidaRec[$i] = str_replace(' ', '_', $unidadeMedidaRec[$i]);
                
                //Quantidade usada por lote convertida p/ unidade de medida do item
                list($idEstoque, $quantUsadaLote) = Receita_Item::selectQuantidadeLote($item, $unidadeMedidaRec[$i], $quantidadeRec[$i]);

                $j = 0;
                foreach($quantUsadaLote as $quantidade){ 
                    $resultadoBaixa = Estoque::registrarBaixa($idEstoque[$j], $idUsuario, $quantidade);

                    if(!$resultadoBaixa){
                        echo "<h2>$resultado</h2>";
                        echo "<button onclick='window.location.href=\"./../visualizar_receita/visualizarReceita.php?id=$idReceita\"'>Retornar à receita</button>";
                        break 3;
                    }
                    
                    //statusItem = '0' se(quantidade == 0 || validade < data atual)
                    if(!Estoque::validarEstoque($idEstoque[$j])){
                        echo "<h2>Falha na validação de estoque do item $idEstoque[$j]</h2><br>";
                    }
                    $j++;
                }
                $i++;
            }

            
            //Atualização da receita p/ as condições do estoque atualizado
            $i = 0;
            foreach($idReceitaItem as $id){
                $custo = Receita::valorItemReceita($idItem[$i], $unidadeMedidaRec[$i], $quantidadeRec[$i]);
        
                $receitaItem = new Receita_Item($idReceita, $idItem[$i], $quantidadeRec[$i], $unidadeMedidaRec[$i], $custo);

                $resultadoUpdate = $receitaItem->editarReceita_Item($id);

                if(!$resultadoUpdate){
                    echo "<h2>Erro ao realizar a atualização da receita...</h2>";
                    echo "<p>$resultado</p>";
                    echo "<button onclick='window.location.href=\"./../visualizar_receita/visualizarReceita.php?id=$idReceita\"'>Retornar à receita</button>";
                    break;
                }
                $i++;
            }   
            
        }
        
        if($resultadoBaixa){
            echo "<h2>Receita realizada com sucesso!</h2>";
            echo "<button onclick='window.location.href=\"./../receitas.php\"'>Retornar às receitas</button>";
            echo "<button onclick='window.location.href=\"./../../Home.php\"'>Retornar à home</button>";
        }
    ?>
</body>
</html>
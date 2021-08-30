<?php
    if(!isset($_POST["nomeReceita"])){
        header('Location: ./cadastro_de_receitas.php');
        die();
    }

    require_once '../../classes/Receita.php';
    require_once '../../classes/Receita_Item.php';
    require_once '../../classes/Usuario.php';
    require_once '../../classes/Item.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $nomeUsuario = $_SESSION['nome_usuario'];
    $email = $_SESSION['email_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../public/css/formStyle.css">
    
    <title>Cadastro de Receita</title>
</head>
<body>
<?php
    $nomeReceita = $_POST["nomeReceita"];
    $rendimento = $_POST["rendimento"];
    $unidadeMedidaRec = $_POST["unidadeMedida"];
    $valorVenda = $_POST["valorVenda"];

    if($unidadeMedidaRec == "unidade_de_medida"){
        echo "<h1>Erro ao realizar cadastro...</h1>";
        echo "<p>Selecione uma unidade de medida para o rendimento!</p>";
        echo "<button><a href='./cadastro_de_receitas.php'>Voltar</a></button>";
        die();
    }

    for($i=1; $i < 99; $i++){
        $indiceIngrediente = "ingrediente".$i;
        $indiceQuantidade = "quantidade".$i;
        $indiceUnidadeMedida = "unidade_de_medida".$i;
                        
        if(!empty($_POST["$indiceIngrediente"])){
            $ingrediente[$i] = $_POST["$indiceIngrediente"];            
        }
        if(!empty($_POST["$indiceQuantidade"])){
            $quantidade[$i] = $_POST["$indiceQuantidade"];
        }
        if(!empty($_POST["$indiceUnidadeMedida"]) && !empty($ingrediente[$i])){
            if($_POST["$indiceUnidadeMedida"] == "unidade_de_medida"){
                echo "<h1>Erro ao realizar cadastro...</h1>";
                echo "<p>Selecione uma unidade de medida para o item: $ingrediente[$i]</p>";
                echo "<button><a href='./cadastro_de_receitas.php'>Voltar</a></button>";
                die();
            }
            $unidadeMedida[$i] = $_POST["$indiceUnidadeMedida"];  
            $unidadeMedida[$i] = mb_strtoupper($unidadeMedida[$i]);
        }
    }

    $receita = new Receita($idUsuario, $nomeReceita, $rendimento, $unidadeMedidaRec, $valorVenda);
    $result = $receita->cadastrarReceita();

    if(!$result){
        echo "<h1>Erro ao realizar cadastro...</h1>";
        echo "<p lang='en'>$result</p>";
        echo "<button><a href='./cadastro_de_receitas.php'>Voltar</a></button>";
        die();
    }
    
    $i = 1;
    foreach($ingrediente as $item){
        $idReceita = Receita::selectId($nomeReceita, $email);
        $idItem = Item::selectId($item, $email);
        
        if(empty($idReceita) || empty($idItem)){
            break;
        }
        $custo = Receita::valorItemReceita($idItem, $unidadeMedida[$i], $quantidade[$i]);
        
        $receitaItem = new Receita_Item($idReceita, $idItem, $quantidade[$i], $unidadeMedida[$i], $custo);
        
        $result = $receitaItem->cadastrarReceita_Item();

        if(!$result){
            echo "<h1>Erro ao realizar cadastro...</h1>";
            echo "<p lang='en'>$result</p>";
            echo "<button><a href='./cadastro_de_receitas.php'>Voltar</a></button>";
            die();
        }
        $i++;
    }
    header('Location: ./../receitas.php');
    die();
?>
</body>
</html>

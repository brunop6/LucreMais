<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Receita</title>
</head>
<body>
<?php
    require_once '../classes/Receita.php';
    require_once '../classes/Receita_Item.php';
    require_once '../classes/Usuario.php';
    require_once '../classes/Item.php';
    
    $nomeReceita = $_POST["nomeReceita"];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $email = Usuario::selectEmail($idUsuario);
    $receita = new Receita($idUsuario, $nomeReceita);
    $receita->cadastrarReceita();

    for($i=1; $i < 99; $i++){
        $indiceIngrediente = "ingrediente".$i;
        $indiceQuantidade = "quantidade".$i;
        $indiceUnidadeMedida = "unidade_de_medida".$i;
        
                            
        if(isset($_POST["$indiceIngrediente"])){
            $ingrediente[$i] = $_POST["$indiceIngrediente"];            
        }
        if(isset($_POST["$indiceQuantidade"])){
            $quantidade[$i] = $_POST["$indiceQuantidade"];
        }
        if(isset($_POST["$indiceUnidadeMedida"])){
            $unidadeMedida[$i] = $_POST["$indiceUnidadeMedida"];
            
        }
    }
    $i = 1;
    foreach($ingrediente as $item){
        $idReceita = Receita::selectId($nomeReceita, $email);
        $idItem = Item::selectId($item, $email);
        $custo = Receita::valorItemReceita($idItem, $idReceita, $quantidade[$i], $unidadeMedida[$i]);
        $receitaItem = new Receita_Item($idReceita, $idItem, $quantidade[$i],$unidadeMedida[$i], $custo);
        $receitaItem->cadastrarReceita_Item();

        $i++;
    }
    


?>
</body>
</html>

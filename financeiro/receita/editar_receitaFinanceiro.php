<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../public/css/inputs.css">
    
    <title>Editar Receita F.</title>
</head>
<body>
<?php
    include_once './../../classes/Usuario.php';
    include_once './../../classes/ReceitaFinanceiro.php';
    include_once './../../classes/CategoriaReceitaFinanceiro.php';
    
    if(!isset($_GET['id'])){   
        header('Location: ./receitaFinanceiro.php');
        die();
    }
     
    $id = $_GET['id'];
    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaReceita'];

    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaReceita = CategoriaReceitaFinanceiro::selectId($descricao);

    $receita = new ReceitaFinanceiro($idUsuario, $idCategoriaReceita, $valor);
    
    if($receita->editar_receita($id)){
        header("Location: ./receitaFinanceiro.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./receitaFinanceiro.php'><button>Retornar</button></a></p>";
?>
</body>
</html>
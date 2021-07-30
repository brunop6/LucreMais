<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../financeiro/receita/receitaFinanceiro.css">
    <title>Cadastro Receita</title>
</head>
<body>
<?php
    include_once '../classes/Usuario.php';
    include_once '../classes/CategoriaReceitaFinanceiro.php';
    include_once '../classes/ReceitaFinanceiro.php';


    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaReceita'];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaReceita = CategoriaReceitaFinanceiro::selectId($descricao);
    
    if(empty($idCategoriaReceita)){
        $categoriaReceita = new CategoriaReceitaFinanceiro($descricao, $idUsuario);
        $categoriaReceita->cadastrarCategoriaReceita();

        $idCategoriaReceita = CategoriaReceitaFinanceiro::selectId($descricao);
    }
    $receita = new ReceitaFinanceiro($idUsuario, $idCategoriaReceita, $valor);
        
    $resultado = $receita->cadastrar_receita();

    if($resultado == "Cadastro realizado com sucesso!"){
        echo "<h2>".$resultado."</h2>";
        echo "<br><p>Descrição: $descricao</p>";
        echo "<p>Valor: $valor</p>";

        echo "<p><a href='cadastro_receitaFinanceiro.php'><button>Cadastrar novo item</button></a></p>";
        echo "<p><a href='./../financeiro/receita/receitaFinanceiro.php'><button>Voltar</button></a></p>";
    }else{
        echo '<h2>Erro ao realizar cadastro...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";
        echo "<p><a href='cadastro_receitaFinanceiro.php'><button>Retornar ao cadastro de receitas</button></a></p>";
    }
?>
</body>
</html>
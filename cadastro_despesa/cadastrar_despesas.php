<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../financeiro/despesa/despesa.css">
    <title>Cadastrar despesas</title>
</head>
<body>
<?php
    include_once '../classes/Usuario.php';
    include_once '../classes/CategoriaDespesa.php';
    include_once '../classes/Despesa.php';

    $custo = $_POST['valor'];
    $descricao = $_POST['categoriaDespesa'];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaDespesa = CategoriaDespesa::selectId($descricao);
    
    if(empty($idCategoriaDespesa)){
        $categoriaDespesa = new CategoriaDespesa($descricao);
        $categoriaDespesa->cadastrarCategoriaDespesa();

        $idCategoriaDespesa = CategoriaDespesa::selectId($descricao);
    }
    $despesa = new Despesa($idUsuario, $idCategoriaDespesa, $custo);
        
    $resultado = $despesa->cadastrar_despesa();

    if($resultado == "Cadastro realizado com sucesso!"){
        echo "<h2>".$resultado."</h2>";
        echo "<br><p>Descrição: $descricao</p>";
        echo "<p>Custo: $custo</p>";

        echo "<p><a href='cadastro_de_despesa.php'><button>Cadastrar novo item</button></a></p>";
        echo "<p><a href='./../financeiro/despesa/despesa.php'><button>Voltar</button></a></p>";
    }else{
        echo '<h2>Erro ao realizar cadastro...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";
        echo "<p><a href='cadastro_de_despesa.php'><button>Retornar ao cadastro de despesas</button></a></p>";
    }
    
?>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../financeiro/recibo/recibo.css">
    <title>Cadastro recibo</title>
</head>
<body>
<?php
    include_once '../classes/Usuario.php';
    include_once '../classes/CategoriaRecibo.php';
    include_once '../classes/Recibo.php';


    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaRecibo'];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaRecibo = CategoriaRecibo::selectId($descricao);
    
    if(empty($idCategoriaRecibo)){
        $categoriaRecibo = new CategoriaRecibo($descricao);
        $categoriaRecibo->cadastrarCategoriaRecibo();

        $idCategoriaRecibo = CategoriaRecibo::selectId($descricao);
    }
    $recibo = new Recibo($idUsuario, $idCategoriaRecibo, $valor);
        
    $resultado = $recibo->cadastrar_recibo();

    if($resultado == "Cadastro realizado com sucesso!"){
        echo "<h2>".$resultado."</h2>";
        echo "<br><p>Descrição: $descricao</p>";
        echo "<p>Valor: $valor</p>";

        echo "<p><a href='cadastro_recibo.php'><button>Cadastrar novo item</button></a></p>";
        echo "<p><a href='../Home.php'><button>Voltar para página inicial</button></a></p>";
    }else{
        echo '<h2>Erro ao realizar cadastro...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";
        echo "<p><a href='cadastro_recibo.php'><button>Retornar ao cadastro de recibos</button></a></p>";
    }
?>
</body>
</html>
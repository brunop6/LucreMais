<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../financeiro/entrada/entrada.css">
    <title>Cadastro Entrada</title>
</head>
<body>
<?php
    include_once '../classes/Usuario.php';
    include_once '../classes/CategoriaEntrada.php';
    include_once '../classes/Entrada.php';


    $valor = $_POST['valor'];
    $descricao = $_POST['categoriaEntrada'];
    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = Usuario::selectId($nomeUsuario);
    $idCategoriaEntrada = CategoriaEntrada::selectId($descricao);
    
    if(empty($idCategoriaEntrada)){
        $categoriaEntrada = new CategoriaEntrada($descricao);
        $categoriaEntrada->cadastrarCategoriaEntrada();

        $idCategoriaEntrada = CategoriaEntrada::selectId($descricao);
    }
    $entrada = new Entrada($idUsuario, $idCategoriaEntrada, $valor);
        
    $resultado = $entrada->cadastrar_entrada();

    if($resultado == "Cadastro realizado com sucesso!"){
        echo "<h2>".$resultado."</h2>";
        echo "<br><p>Descrição: $descricao</p>";
        echo "<p>Valor: $valor</p>";

        echo "<p><a href='cadastro_entrada.php'><button>Cadastrar novo item</button></a></p>";
        echo "<p><a href='./../financeiro/entrada/entrada.php'><button>Voltar</button></a></p>";
    }else{
        echo '<h2>Erro ao realizar cadastro...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";
        echo "<p><a href='cadastro_entrada.php'><button>Retornar ao cadastro de entradas</button></a></p>";
    }
?>
</body>
</html>
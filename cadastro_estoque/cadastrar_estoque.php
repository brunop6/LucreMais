<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../cadastro_item/aparenciaitem.css">
    <title>Cadastro Estoque</title>
</head>
<body>
    <?php
        include '../includes/conecta_bd.inc';
        include_once '../classes/Estoque.php';
        include_once '../classes/Usuario.php';

        if(!isset($_GET['idFornecedor']) || !isset($_GET['idItem']) || !isset($_GET['quantidade']) || !isset($_GET['preco']) || !isset($_GET['lote'])){
            die();
            header('Location: cadastro_estoque.php');
            die();
        }
        
        session_start();
        $nomeUsuario = $_SESSION['nome_usuario'];
        $idUsuario = Usuario::selectId($nomeUsuario);
        $idFornecedor = $_GET['idFornecedor'];
        $idItem = $_GET['idItem'];
        $quantidade = $_GET['quantidade'];
        $preco = $_GET['preco'];
        $lote = $_GET['lote'];

        $estoque = new Estoque($idUsuario, $idFornecedor, $idItem, $quantidade, $preco, $lote, '1');

        $resultado = $estoque->cadastrar_estoque();

        if($resultado == 'Cadastro realizado com sucesso!'){
            echo "<h2>$resultado</h2> <br>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
        }
        echo "<p><a href='../estoque/estoque.php'><button>Retornar ao Estoque</button></a></p>";
    ?>
</body>
</html>

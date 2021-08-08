<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../../../public/css/inputs.css">

    <title>Editar Categoria</title>
</head>
<body>
<?php
    include_once '../../../classes/CategoriaDespesa.php';
    include_once '../../../classes/Usuario.php';

    if(!isset($_GET['id']) || !isset($_POST['categoriaDespesa'])){
        header('Location: categoria.php');
        die();
    }
    
    session_start();
    $id = $_GET['id'];
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
    $descricao = $_POST['categoriaDespesa'];

    $categoria = new CategoriaDespesa($descricao, $idUsuario);

    if($categoria->editarCategoria($id)){
        header("Location: ./categoria.php");
    }else{
        echo '<h2>Erro ao realizar edição...</h2> <br>';
        echo "<p lang='en'>".$resultado."</p>";  
    }
    echo "<p><a href='./categoria.php'><button>Retornar às Categorias</button></a></p>";
?>
</body>
</html>
<?php
    define('menu', 'Itens');
    include_once "../../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
    include_once '../../../classes/CategoriaEntrada.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $descricao = CategoriaEntrada::selectCategoria($id);
    }else{
        header('Location: ./categoria.php');
        die();
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria Entrada</title>
    <link rel="stylesheet" href="../../../cadastro_item/aparenciaitem.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./edita_categoria.js"></script>

</head>
<body>
    <img src="../../../Logo.png" alt="Logo do site" width="14%">
    <form action="editar_categoria.php?id=<?php echo $id?>" method="POST">
        <h3>Categoria: <?php echo $id?></h3>
        <p><input type="text" name="categoriaEntrada" id="categoriaEntrada" value="<?php echo $descricao?>" list="categorias" oninput="preencherCategorias()" required></p>
        <datalist id="categorias">

        </datalist>
        <p>
            <input type="submit" value="Salvar" name="salvar">
            <input type="button" value="Cancelar" onclick="window.location.href='./categoria.php'">
        </p>
    </form>
</body>
</html>
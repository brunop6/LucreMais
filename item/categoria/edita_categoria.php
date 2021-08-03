<?php
    define('menu', 'Itens');
    include_once "../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    include_once '../../classes/Categoria.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $descricaoCategoria = Categoria::selectCategoria($id);
    }else{
        header('Location: ./categoria.php');
        die();
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./../../public/js/datalists.js"></script>

    <link rel="stylesheet" href="./../../public/css/formStyle.css">
    
    <title>Editar Categoria</title>
</head>
<body>
    <img src="../../public/img/Logo.png" alt="Logo do site" width="14%">
    <form action="editar_categoria.php?id=<?php echo $id?>" method="POST">
        <h3>Categoria: <?php echo $id?></h3>
        <p><input type="text" name="categoria" id="categoria" value="<?php echo $descricaoCategoria?>" list="categorias" oninput="preencherCategorias()" required></p>
        <datalist id="categorias">

        </datalist>
        <p>
            <input type="submit" value="Salvar" name="salvar">
            <input type="button" value="Cancelar" onclick="window.location.href='./categoria.php'">
        </p>
    </form>
</body>
</html>
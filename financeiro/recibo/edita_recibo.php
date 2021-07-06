<?php
    define('menu', 'Itens');
    include_once './../../classes/Usuario.php';
    include_once './../../classes/Recibo.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    $id = $_GET['id'];
    list($descricao, $custo) = Recibo::selectRecibosLista($id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../fornecedor/fornecedor.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./edita_recibo.js"></script>
    <title>Edição de Recibo</title>
</head>
<body>
    <img src="../../Logo.png" alt="Logo do site" width="14%">
    <form action="editar_recibo.php?id=<?php echo $id ?>" method="POST" >     
        <h3>Categoria</h3>
        <p><input type="text" name="categoriaRecibo" id="categoriaRecibo" list="categorias" value="<?php echo $descricao ?>" oninput="preencherCategorias()" required></p>
        <datalist id="categorias">

        </datalist>
        <h3>Custo: </h3>
        <p><input type="text" name="valor" list="valor" value="<?php echo $custo?>"required></p>
            <input type="submit" value="Salvar" name="salvar" >
            <input type="button" value="Cancelar" onclick="window.location.href='./recibo.php'">
        </p>
    </form>
    
</body>
</html>
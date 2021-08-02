<?php
    define('menu', 'Itens');
    include_once './../../classes/Usuario.php';
    include_once './../../classes/Despesa.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    $id = $_GET['id'];
    list($descricao, $custo) = Despesa::selectDespesa($id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edição de despesa</title>
    <link rel="stylesheet" href="../../fornecedor/fornecedor.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./../../public/js/datalists.js"></script>
</head>
<body>
    <img src="../../public/img/Logo.png" alt="Logo do site" width="14%">
    <form action="editar_despesa.php?id=<?php echo $id ?>" method="POST" >     
        <h3>Categoria</h3>
        <p><input type="text" name="categoriaDespesa" id="categoriaDespesa" list="categorias" value="<?php echo $descricao ?>" oninput="preencherCategoriaDespesa()" required></p>
        <datalist id="categorias">

        </datalist>
        <h3>Custo: </h3>
        <p><input type="text" name="valor" list="valor" value="<?php echo $custo?>"required></p>
            <input type="submit" value="Salvar" name="salvar" >
            <input type="button" value="Cancelar" onclick="window.location.href='./despesa.php'">
        </p>
    </form>
    
</body>
</html>
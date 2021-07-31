<?php
    define('menu', 'Itens');
    include_once "../classes/Usuario.php";
    include_once '../classes/Item.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];

    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
    $id =  $_GET['id'];
    list($nome, $marca, $quantidade, $unidadeMedida, $descricaoCategoria, $quantidadeMinima) = Item::selectItemLista($id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edição de item</title>
    <link rel="stylesheet" href="./../fornecedor/fornecedor.css">
</head>
<body>
    <img src="./../public/img/Logo.png" alt="Logo do site" width="14%">
    <form action="editar_item.php?id=<?php echo $id ?>" method="POST" >     
        <h3>Marca: </h3>
        <p><input type="text" name="marca" list="marcas" value="<?php echo $marca ?>" required></p>
        <datalist id="marcas">
        </datalist>
        <h3>Nome: </h3>
        <p><input type="text" name="nome" list="nomes" value="<?php echo $nome ?>" required></p>
        <datalist id="nomes">
        </datalist>
        <h3>Categoria</h3>
        <p><input type="text" name="categoria" list="categorias" value="<?php echo $descricaoCategoria ?>" required></p>
        <datalist id="categorias">
        </datalist>
        <h3>Quantidade: </h3>
        <p><input type="number" name="quantidade" step="0.1" value="<?php echo $quantidade ?>" required></p>
        <h3>Quantidade mínima: </h3>
        <p><input type="number" name="quantidadeMinima" value="<?php echo $quantidadeMinima ?>" step="0.1" required></p>
        <h3>Unidade de medida: </h3>
        
        <select name="unidade_de_medida" id="unidadeMedida" required>
            <option value="unidade_de_medida">Unidade de Medida</option>
            <option value="unidade(s)" 
            <?php
                if($unidadeMedida == mb_strtoupper("unidade(s)")){
                    echo 'selected';
                }
            ?>
            >Unidade(s)</option>

            <option value="litro(s)"
            <?php
                if($unidadeMedida == mb_strtoupper("litro(s)")){
                    echo 'selected';
                }
            ?>
            >Litro(s)</option>

            <option value="ml"
            <?php
                if($unidadeMedida == mb_strtoupper("ml")){
                    echo 'selected';
                }
            ?>
            >ml</option>

            <option value="gramas"
            <?php
                if($unidadeMedida == mb_strtoupper("gramas")){
                    echo 'selected';
                }
            ?>
            >Gramas</option>

            <option value="colher_de_sopa" >Colher de Sopa</option>
            <option value="colher_de_cha" >Colher de Chá</option>
            <option value="colher_de_cafe">Colher de Café</option>
            <option value="xicara">Xícara</option>
            <option value="quilo(s)"
            <?php
                if($unidadeMedida == mb_strtoupper("quilo(s)")){
                    echo 'selected';
                }
            ?>
            >Quilo</option>
        </select>
        <p>
            <input type="submit" value="Salvar" name="salvar" >
            <input type="button" value="Cancelar" onclick="window.location.href='./item.php'">
        </p>
    </form>
    
</body>
</html>
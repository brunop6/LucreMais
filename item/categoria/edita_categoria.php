<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="../../cadastro_item/aparenciaitem.css">
</head>
<body>
    <img src="../Logo.png" alt="Logo do site" width="14%">
    <form action="" method="POST">
        <h3>Categoria: </h3>
        <p><input type="text" name="categoria" value="<?php echo $estoqueFornecedor?>" list="fornecedores" required></p>
        <datalist id="fornecedores">
            <?php
                atualizarFornecedores();
            ?>
        </datalist>
        
        <h3>Descrição: </h3>
        <p><input type="text" name="item" value="<?php echo $estoqueNome.' '.$estoqueMarca?>" list="itens" required>
            
            <?php
                if(isset($idItem) && $idItem == null){
                    echo '
                    <script> alert("Item não cadastrado no sistema"); </script>
                    <button><a href="../cadastro_item/cadastro_de_itens.php">Cadastrar Item</a></button>
                    ';
                }
            ?>
        </p>
        <datalist id="itens">
            <?php
                atualizarItens();
            ?>
        </datalist>
        <p>
            <input type="submit" value="Salvar" name="salvar">
            <input type="button" value="Cancelar" onclick="window.location.href='./categoria.php'">
        </p>
    </form>
</body>
</html>
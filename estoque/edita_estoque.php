<?php
    include '../includes/conecta_bd.inc';
    include_once '../classes/Fornecedor.php';
    include_once '../classes/Item.php';
    include_once '../classes/Estoque.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        list($estoqueNome, $estoqueMarca, $estoqueUnMedida, $estoqueFornecedor, $estoqueQuantidade, $estoquePreco, $estoqueLote, $estoqueStatus) = Estoque::selectEstoque($id);
    }else{
        header("Location: ./estoque.php");
        die();
    }
    
    //Validação de Fornecedor e Item inseridos no formulário
    if(isset($_POST['salvar'])){
        $fornecedor = strtoupper($_POST['fornecedor']);
        $item = strtoupper($_POST['item']);
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $lote = $_POST['lote'];
        $status = $_POST['status'];

        $fornecedores = Fornecedor::selectFornecedores();
        $idFornecedor = null;

        //Buscando o fornecedor inserido no banco de dados
        foreach($fornecedores as $nomeFornecedor){
            //Caso encontre o nome de um fornecedor cadastrado no texto inserido, a função não retornará false
            if(strpos($fornecedor, $nomeFornecedor) !== false){
                $idFornecedor = Fornecedor::selectId($nomeFornecedor);
                break;
            }
        }

        list($marca, $nome) = Item::selectItens();

        $i = 0;
        $idItem = null;

        //Buscando o item inserido no banco de dados
        foreach($nome as $nomeItem){
            if(strpos($item, $nomeItem) !== false){
                if(strpos($item, $marca[$i]) !== false){
                    $idItem = Item::selectId($nomeItem, $marca[$i]);
                    break;
                }
            }
            $i++;
        }

        //Fomulário só será enviado quando houver a inserção de fornecedor e item válido no sistema
        if($idItem != null && $idFornecedor != null){
            header("Location: editar_estoque.php?id=$id&idFornecedor=$idFornecedor&idItem=$idItem&quantidade=$quantidade&preco=$preco&lote=$lote&status=$status");
            die();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Estoque</title>
    <?php
        function atualizarFornecedores(){
            $fornecedores = Fornecedor::selectFornecedores();

            if(!empty($fornecedores)){
                foreach($fornecedores as $value){
                    echo "<option value='$value'></option>";
                }
            }
        }
        function atualizarItens(){
            list($marca, $nome) = Item::selectItens();

            if(!empty($marca)){
                $i = 0;
                foreach($nome as $nomeItem){
                    echo "<option value='$nomeItem $marca[$i]'></option>";
                    $i++;
                }
            }
        }
    ?>
    <link rel="stylesheet" href="../cadastro_item/aparenciaitem.css">
</head>
<body>
    <img src="../Logo.png" alt="Logo do site" width="14%">
    <form action="" method="POST">
        <h3>Fornecedor: </h3>
        <p><input type="text" name="fornecedor" value="<?php echo $estoqueFornecedor?>" list="fornecedores" required>
            <?php
                if(isset($idFornecedor) && $idFornecedor == null){
                    echo '
                    <script> alert("Fornecedor não cadastrado no sistema"); </script>
                    <button><a href="../fornecedor/cadastro_fornecedor.php">Cadastrar Fornecedor</a></button>
                    ';
                }
            ?> 
        </p>
        <datalist id="fornecedores">
            <?php
                atualizarFornecedores();
            ?>
        </datalist>
        
        <h3>Item: </h3>
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
        
        <h3>Quant. Estoque (<?php echo $estoqueUnMedida?>):</h3>
        <p><input type="number" name="quantidade" value="<?php echo $estoqueQuantidade?>" step="0.1" required></p>
        
        <h3>Preço R$:</h3>
        <p><input type="number" name="preco" value="<?php echo $estoquePreco?>" step="0.01" required></p>
        
        <h3>Lote: </h3>
        <p><input type="number" name="lote" value="<?php echo $estoqueLote?>" required></p>
        
        <h3>Status:</h3>

        <p><input type="radio" name="status" value="1" 
            <?php 
                if($estoqueStatus == "1"){
                    echo "checked";
                }
            ?>
        >Ativo</input></p>

        <p><input type="radio" name="status" value="0"
            <?php 
                if($estoqueStatus == "0"){
                    echo "checked";
                }
            ?>
        >Inativo</input></p>
        <p>
            <input type="submit" value="Salvar" name="salvar">
            <input type="button" value="Cancelar" onclick="window.location.href='./estoque.php'">
        </p>
    </form>
</body>
</html>
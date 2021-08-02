<?php
    define('menu', 'Estoque');
    include_once "../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    
    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
    include_once '../../classes/Fornecedor.php';
    include_once '../../classes/Item.php';
    include_once '../../classes/Estoque.php';

    if(isset($_GET['id'])){
        $idEstoque = $_GET['id'];
        list($estoqueNome, $estoqueMarca, $estoqueUnMedida, $estoqueFornecedor, $estoqueQuantidade, $estoquePreco, $estoqueLote, $estoqueValidade, $estoqueStatus) = Estoque::selectEstoque($idEstoque);
    }else{
        header("Location: ./../estoque.php");
        die();
    }
    
    //Validação de Fornecedor e Item inseridos no formulário
    if(isset($_POST['salvar'])){
        $fornecedor = strtoupper($_POST['fornecedor']);
        $item = strtoupper($_POST['item']);
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $lote = $_POST['lote'];
        $validade = $_POST['validade'];
        $status = $_POST['status'];

        if($estoqueQuantidade < $quantidade){
            $quantidadeMovimento = $quantidade - $estoqueQuantidade;
            $tipoOperação = "E"; //Entrada
        }elseif($estoqueQuantidade > $quantidade){
            $quantidadeMovimento = $estoqueQuantidade - $quantidade;
            $tipoOperação = "S"; //Saída
        }
        list($id, $fornecedores, $email, $telefone, $cnpj, $endereco, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Fornecedor::selectFornecedores($emailUsuario);
        $idFornecedor = null;

        //Buscando o fornecedor inserido no banco de dados
        foreach($fornecedores as $nomeFornecedor){
            //Caso encontre o nome de um fornecedor cadastrado no texto inserido, a função não retornará false
            if(strpos($fornecedor, $nomeFornecedor) !== false){
                $idFornecedor = Fornecedor::selectId($nomeFornecedor, $emailUsuario);
                break;
            }
        }

        list($marca, $nome) = Item::selectItens($emailUsuario);

        $i = 0;
        $idItem = null;

        $idItem = Item::selectId($item, $emailUsuario);

        //Fomulário só será enviado quando houver a inserção de fornecedor e item válido no sistema
        if($idItem != null && $idFornecedor != null){
            if(!isset($quantidadeMovimento)){
                header("Location: editar_estoque.php?id=$idEstoque&idFornecedor=$idFornecedor&idItem=$idItem&quantidade=$quantidade&preco=$preco&lote=$lote&validade=$validade&status=$status");
                die();
            }else{
                header("Location: editar_estoque.php?id=$idEstoque&idFornecedor=$idFornecedor&idItem=$idItem&quantidade=$quantidadeMovimento&tipo=$tipoOperação&preco=$preco&lote=$lote&validade=$validade&status=$status");
            die();
            }
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
    <link rel="stylesheet" href="../../item/cadastro_item/aparenciaitem.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./../../public/js/datalists.js"></script>
</head>
<body>
    <img src="./../../public/img/Logo.png" alt="Logo do site" width="14%">
    <form action="" method="POST">
        <h3>Fornecedor: </h3>
        <p><input type="text" name="fornecedor" id="fornecedor" value="<?php echo $estoqueFornecedor?>" list="fornecedores" oninput="preencherFornecedores()" required>
            <?php
                if(isset($idFornecedor) && $idFornecedor == null){
                    echo '
                    <script> alert("Fornecedor não cadastrado no sistema"); </script>
                    <button><a href="../../fornecedor/cadastro_fornecedor.php">Cadastrar Fornecedor</a></button>
                    ';
                }
            ?> 
        </p>
        <datalist id="fornecedores">
        </datalist>
        
        <h3>Item: </h3>
        <p><input type="text" name="item" id="item" value="<?php echo $estoqueNome.' '.$estoqueMarca?>" list="itens" oninput="preencherItens()" required>
            
            <?php
                if(isset($idItem) && $idItem == null){
                    echo '
                    <script> alert("Item não cadastrado no sistema"); </script>
                    <button><a href="../../item/cadastro_item/cadastro_de_itens.php">Cadastrar Item</a></button>
                    ';
                }
            ?>
        </p>
        <datalist id="itens">
        </datalist>
        
        <h3>Quant. Estoque (<?php echo $estoqueUnMedida?>):</h3>
        <p><input type="number" name="quantidade" value="<?php echo $estoqueQuantidade?>" step="0.1" required></p>
        
        <h3>Preço R$:</h3>
        <p><input type="number" name="preco" value="<?php echo $estoquePreco?>" step="0.01" required></p>
        
        <h3>Lote: </h3>
        <p><input type="number" name="lote" value="<?php echo $estoqueLote?>" required></p>
        
        <h3>Validade:</h3>
        <p><input type="date" name="validade" value="<?php echo $estoqueValidade ?>" required></p>
        
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
            <input type="button" value="Cancelar" onclick="window.location.href='./../estoque.php'">
        </p>
    </form>
</body>
</html>
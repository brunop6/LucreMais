<?php
    define('menu', 'Estoque');
    include_once '../../classes/Fornecedor.php';
    include_once '../../classes/Item.php';
    include_once '../../classes/Usuario.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../../Home.php");
        die();
    }
    //Validação de Fornecedor e Item inseridos no formulário
    if(isset($_POST['cadastrar'])){
        $fornecedor = strtoupper($_POST['fornecedor']);
        $item = strtoupper($_POST['item']);
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $lote = $_POST['lote'];
        $validade = $_POST['validade'];

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

        //Buscando o item inserido no banco de dados
        $idItem = Item::selectId($item, $emailUsuario);


        //Fomulário só será enviado quando houver a inserção de fornecedor e item válido no sistema
        if($idItem != null && $idFornecedor != null){
            header("Location: cadastrar_estoque.php?idFornecedor=$idFornecedor&idItem=$idItem&quantidade=$quantidade&preco=$preco&lote=$lote&validade=$validade");
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="cadastro_estoque.js"></script>
    <title>Cadastro Estoque</title>
    <link rel="stylesheet" href="../../item/cadastro_item/aparenciaitem.css">
</head>
<body>
    <img src="./../../public/img/Logo.png" alt="Logo do site" width="14%">
    <form action="" method="POST">
        <p><input type="text" name="fornecedor" id="fornecedor" placeholder="Fornecedor" list="fornecedores" oninput="preencherFornecedores()" required>
            <?php
                if(isset($idFornecedor) && $idFornecedor == null){
                    echo '
                    <script> alert("Fornecedor não cadastrado no sistema"); </script>
                    <button><a href="../../fornecedor/cadastro_fornecedor/cadastro_fornecedor.php">Cadastrar Fornecedor</a></button>
                    ';
                }
            ?> 
        </p>
        <datalist id="fornecedores">
        
        </datalist>
        <p><input type="text" name="item" id="item" placeholder="Item" list="itens" oninput="preencherItens()" required>
            
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
        
        <p><input type="number" name="quantidade" placeholder="Quantidade Estoque" step="0.1" required></p>
        <p><input type="number" name="preco" placeholder="Preço R$" step="0.01" required></p>
        <p><input type="number" name="lote" placeholder="Lote" required></p>
        <p><input type="date" name="validade" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required></p>
        <p><input type="submit" value="Cadastrar" name="cadastrar"></p>
        <p><input type="button" value="Voltar" onclick="window.location.href='../estoque.php'"></p>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aparenciaitem.css">
    <title>Cadastro de Item</title>
</head>
<body>
    <?php
        include_once '../classes/Usuario.php';
        include_once '../classes/Item.php';
        include_once '../classes/Fornecedor.php';
        include_once '../classes/Categoria.php';

        $nome = $_POST['nome'];
        $descricaoCategoria = $_POST['categoria'];
        $nomeFornecedor = $_POST['fornecedor'];
        $quantidade = $_POST['quantidade'];
        $unidadeMedida = $_POST['unidade_de_medida'];
        $preco = $_POST['preco'];
        $quantMinima = $_POST['quantMinima'];
        $lote = $_POST['lote'];
        $status = $_POST['status'];

        session_start();
        $nomeUsuario = $_SESSION['nome_usuario'];

        $idUsuario = Usuario::selectId($nomeUsuario);
        $idFornecedor = Fornecedor::selectId($nomeFornecedor);
        $idCategoria = Categoria::selectId($descricaoCategoria);

        //Caso não haja retorno do $idCategoria, será realizado o cadastro da nova categoria
        if(empty($idCategoria)){
            $categoria = new Categoria($idUsuario, $descricaoCategoria);
            $categoria->cadastrarCategoria();

            $idCategoria = Categoria::selectId($descricaoCategoria);
        }

        $item = new Item($idUsuario, $idFornecedor, $idCategoria, $nome, $quantidade, $unidadeMedida, $preco, $quantMinima, $lote, $status);

        $resultado = $item->cadastrar_item();

        if($resultado == "Cadastro realizado com sucesso!"){
            echo "<h2>".$resultado."</h2>";
            
            echo "<br><p>Item: $nome</p>";
            echo "<p>Quantidade: $quantidade $unidadeMedida</p>";
            echo "<p>Preço: R$".$preco."</p>";
            echo "<p>Quantidade mínima: $quantMinima $unidadeMedida</p>";
            echo "<p>Lote: $lote</p>";

            echo "<p><a href='./cadastro_de_itens.php'><button>Cadastrar novo item</button></a></p>";
            echo "<p><a href='../Home.php'><button>Voltar para página inicial</button></a></p>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";
            echo "<p><a href='./cadastro_de_itens.php'><button>Retornar ao cadastro de itens</button></a></p>";
        }
    ?>
</body>
</html>
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
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $descricaoCategoria = mb_strtoupper($_POST['categoria'], mb_internal_encoding());
    $quantidade = $_POST['quantidade'];
    $unidadeMedida = $_POST['unidade_de_medida'];
    $quantidadeMinima = $_POST['quantidadeMinima'];

    session_start();
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    $idCategoria = Categoria::selectId($descricaoCategoria, $emailUsuario);
    if(empty($idCategoria)){
      $categoria = new Categoria($idUsuario, $descricaoCategoria);
      $categoria->cadastrarCategoria();

      $idCategoria = Categoria::selectId($descricaoCategoria, $emailUsuario);
    }
    $item = new Item($idUsuario, $idCategoria, $marca, $nome, $quantidade, $unidadeMedida, $quantidadeMinima);

    $resultado = $item->cadastrar_item();

    if($resultado == "Cadastro realizado com sucesso!"){
      echo "<h2>".$resultado."</h2>";
      echo "<br><p>Item: $nome</p>";
      echo "<br><p>Marca: $marca</p>";
      echo "<p>Quantidade: $quantidade $unidadeMedida</p>";
      echo "<p>Quantidade mínima: $quantidadeMinima $unidadeMedida</p>";
      echo "<p><a href='./cadastro_de_itens.php'><button>Cadastrar novo item</button></a></p>";
      echo "<p><a href='./../item/item.php'><button>Voltar</button></a></p>";
    }else{
      echo '<h2>Erro ao realizar cadastro...</h2> <br>';
      echo "<p lang='en'>".$resultado."</p>";
      echo "<p><a href='./cadastro_de_itens.php'><button>Retornar ao cadastro de itens</button></a></p>";
    }
  ?>
</body>
</html>
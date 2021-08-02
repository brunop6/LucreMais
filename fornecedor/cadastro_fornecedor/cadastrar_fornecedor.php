<!DOCTYPE html>
<html lang="pr-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../public/css/inputs.css">
    
    <title>Cadastro Fornecedor</title>
</head>
<body>
    <?php
        include '../../includes/conecta_bd.inc';
        include_once '../../classes/Fornecedor.php';
        include_once '../../classes/Usuario.php';

        $nome = $_POST['nomeFornecedor'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cnpj = $_POST['cnpj'];
        $endereco = $_POST['endereco'];

        session_start();
        $nomeUsuario = $_SESSION['nome_usuario'];
        
        $idUsuario = Usuario::selectId($nomeUsuario);

        $fornecedor = new Fornecedor($idUsuario, $nome, $email, $telefone, $cnpj, $endereco);
        
        $resultado = $fornecedor->cadastrarFornecedor();

        if($resultado == "Cadastro realizado com sucesso!"){
            header('Location: ./../fornecedor.php');
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
        }
        echo "<p><a href='../../Home.php'><button>Retornar a página principal</button></a></p>";
    ?>
</body>
</html>
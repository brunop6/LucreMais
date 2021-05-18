<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Login/aparencial.css">
    <title>Cadastro Usuário</title>
</head>
<body>
    <?php
        include_once '../classes/Usuario.php';

        $nomeUsuario = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuario = new Usuario($nomeUsuario, $email, $senha);

        $resultado = $usuario->cadastrarUsuario();

        if($resultado == "Cadastro realizado com sucesso!"){
            echo "<h2>$resultado</h2> <br>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
        }
        echo "<p><a href='../Login/login.php'><button>Retornar ao login</button></a></p>";
    ?>
</body>
</html>
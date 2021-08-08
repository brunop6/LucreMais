<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../public/css/inputs.css">
    
    <title>Cadastro Usuário</title>
</head>
<body>
    <?php
        include_once '../../classes/Usuario.php';

        $nomeUsuario = $_POST['usuario'];
        $email = $_POST['email'];

        if(!Usuario::verificarEmail($email)){
            echo '<h3>Erro ao realizar cadastro...</h3> <br>';
            echo '<p>O e-mail utilizado já possui um Administrador!</p> <br>';
            echo "<p><a href='../../Login/login.php'><button>Retornar ao login</button></a></p>";
            die();
        }
        $senha = $_POST['senha'];

        /**
         * Caso a verificação do e-mail retorne true, o usuário cadastrado será o primeiro do grupo,
         * possuindo então permissão de administrador (admin = '1') e status ativo (statusUsuario = '1')
         */
        $usuario = new Usuario('1', $nomeUsuario, $email, $senha, '1');

        $resultado = $usuario->cadastrarUsuario();

        if($resultado){
            echo "<h2>Cadastro realizado com sucesso!</h2> <br>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
        }
        echo "<p><a href='../../Login/login.php'><button>Retornar ao login</button></a></p>";
    ?>
</body>
</html>
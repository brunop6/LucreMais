<?php
    if(!isset($_POST['nome']) || !isset($_POST['senha'])){
        header('location: ./edita_usuario.php');
        die();
    }
    include_once './../../classes/Usuario.php';
    include_once './../../includes/encrypt.inc';

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    $nomeUsuario = $_POST['nome'];
    $senha = $_POST['senha'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../public/css/inputs.css">

    <title>Edição de Usuário</title>
</head>
<body>
    <?php
        if(Usuario::admin($idUsuario)){
            $admin = 1;
        }else{
            $admin = 0;
        }

        $usuario = new Usuario($admin, $nomeUsuario, $emailUsuario, $senha);

        $resultado = $usuario->editarConta($idUsuario);

        if($resultado){
            $senha = encryptPassword($nomeUsuario, $_SESSION['email_usuario'], $senha);

            $_SESSION['nome_usuario'] = $nomeUsuario;
            $_SESSION['senha_usuario'] = $senha;
            
            header('location: ./../../Home.php');
            die();
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
            echo "<p><a href='./../../Home.php'><button>Voltar</button></a></p>";
        }
    ?>
</body>
</html>
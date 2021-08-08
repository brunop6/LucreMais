<?php
    if(!isset($_POST['nome'])){
        header('location: ./edita_usuario.php');
        die();
    }
    include_once './../../classes/Usuario.php';
    include_once './../../includes/encrypt.inc';

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    
    if(strlen($_POST['senha']) > 0){
        $senha = $_POST['senha'];
    }else{
        $senha = false;
    }
    
    $idUsuario = $_SESSION['id_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];
    $nomeUsuario = $_POST['nome'];
    $statusUsuario = $_POST['statusUsuario'];

    if(Usuario::admin($idUsuario)){
        $admin = 1;
    }else{
        $admin = 0;
    }
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
        echo "<p hidden id='status'>$statusUsuario</p>";
    ?>

    <?php
        $usuario = new Usuario($admin, $nomeUsuario, $emailUsuario, $senha, $statusUsuario);

        $resultado = $usuario->editarConta($idUsuario);

        if($resultado){
            $_SESSION['nome_usuario'] = $nomeUsuario;
            $_SESSION['status_usuario'] = $statusUsuario;

            if($senha !== false){
                $senha = encryptPassword($nomeUsuario, $_SESSION['email_usuario'], $senha);
                
                $_SESSION['senha_usuario'] = $senha;
            }
            
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

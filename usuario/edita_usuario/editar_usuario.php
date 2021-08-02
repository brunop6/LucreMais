<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>
<body>
    <?php
        if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
        include_once '../.././classes/Usuario.php';

        $nomeUsuario = $_POST['nome'];
        $senhaUsuario = $_POST['senha'];
    
        $usuario = new Usuario('0', $nomeUsuario, $_SESSION["email_usuario"], $senhaUsuario);
    
        $idUsuario = $usuario->selectId($nomeUsuario);

        $resultado = $usuario->editarContaUsusario($idUsuario);

        if($resultado){
            echo "<h2>Senha alterada com sucesso!</h2> <br>";
              $_SESSION["senha_usuario"] = $senhaUsuario;
        }else{
            echo '<h2>Erro ao alterar senha...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
        }
        echo "<p><a href='../../Home.php'><button>Retornar a página principal</button></a></p>";
    ?>
</body>
</html>

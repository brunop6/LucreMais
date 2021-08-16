<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../public/css/inputs.css">
    
    <title>Cadastro funcionário</title>
</head>
<body>
    <?php
        if(!isset($_POST['usuario']) || !isset($_POST['senha'])){
            header('location: ./../permissoes/permissoes.php');
            die();
        }

        include './../../includes/validacao_cookies.inc';
        include_once '../../classes/Usuario.php';
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $email = $_SESSION['email_usuario'];
        $nivelAcesso = $_POST['nivel_de_acesso'];

        $nomeUsuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $admin = $_POST['admin'];
    
        /**
         * admin = '0'          -> func. padrão
         * statusUsuario = '1'  -> ativo
         */
        $usuario = new Usuario($admin, $nomeUsuario, $email, $senha, '1');
        $resultado = $usuario->cadastrarUsuario();

        $idUsuario = Usuario::selectId($nomeUsuario);

        if($resultado){
            if($admin == '0'){
                $resultado = Usuario::cadastrarNivelUsuario($idUsuario, $nivelAcesso);

                if(!$resultado){
                    echo '<h2>Erro ao vincular nível de acesso...</h2> <br>';
                    echo "<p lang='en'>".$resultado."</p>";  
                    echo "<p><a href='./../permissoes/permissoes.php'><button>Retornar às permissões</button></a></p>";
                }
            }
            header('location: ./../permissoes/permissoes.php');
            die();
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".$resultado."</p>";  
            echo "<p><a href='./../permissoes/permissoes.php'><button>Retornar às permissões</button></a></p>";
        } 
    ?>
</body>
</html>

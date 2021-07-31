<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         include './../../includes/validacao_cookies.inc';
         include_once '../../classes/Usuario.php';
         if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

         $nomeUsuario = $_POST['usuario'];
         $email = $_SESSION['email_usuario'];
         $senha = $_POST['senha'];
         $nivelAcesso = $_POST['nivel_de_acesso'];
         print_r($nivelAcesso);
      
         $usuario = new Usuario('0', $nomeUsuario, $email, $senha);
         $resultado = $usuario->cadastrarUsuario();

         $idUsuario = Usuario::selectId($nomeUsuario);

         if($resultado){
             echo "<h2>Cadastro realizado com sucesso!</h2> <br>";
             $resultado = Usuario::cadastrarNivelUsuario($idUsuario, $nivelAcesso);
             print_r($resultado);
             die();
         }else{
             echo '<h2>Erro ao realizar cadastro...</h2> <br>';
             echo "<p lang='en'>".$resultado."</p>";  
         }
         echo "<p><a href='../../Login/login.php'><button>Retornar ao login</button></a></p>";
    ?>
</body>
</html>
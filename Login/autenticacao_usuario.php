<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="./../public/css/formStyle.css">

    <title>Autenticação de Usuário</title>
</head>
<body>
    <?php      
        include "./../includes/encrypt.inc";
        include_once "./../classes/Usuario.php";
        
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        $idUsuario = Usuario::selectId($usuario);
        list($admin, $res_usuario, $res_email, $res_senha, $statusUsuario) = Usuario::infoUsuario($idUsuario);
        
        if(empty($idUsuario)){
            echo "<h3>Usuário não encontrado!</h3>";
            echo "<p><button><a href=\"login.php\">Voltar</button></p>";
        }else{
            if($statusUsuario == '0'){
                echo '<h3>Ops. Parece que essa conta foi desativada...</h3><br>';
                echo '<p>É necessário que uma conta administradora desbloqueie seu acesso.</p>';
                echo "<p><button><a href=\"login.php\">Voltar</button></p>";
                
                die();
            }    
            $senha = encryptPassword($res_usuario, $res_email, $senha);

            if($senha != $res_senha){
                echo "<h3>Senha incorreta!</h3>";
                echo "<p><button><a href=\"login.php\">Voltar</button></p>";
            }else{
                if(Usuario::admin($idUsuario)){
                    $nivelAcesso = "Administrador";
                }else{
                    $nivelAcesso = Usuario::selectNivel($idUsuario);                
                }
                
                session_start();
                $_SESSION["id_usuario"] = $idUsuario;
                $_SESSION["nome_usuario"] = $usuario;
                $_SESSION["senha_usuario"] = $senha;
                $_SESSION["email_usuario"] = $res_email;
                $_SESSION["nivel_usuario"] = $nivelAcesso;
                $_SESSION["status_usuario"] = $statusUsuario;
                    
                header("Location: ./../Home.php");
            }
        }
      
        mysqli_close($conexao);
    ?>
</body>
</html>
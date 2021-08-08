<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <link rel="icon" href="./../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./../public/css/formStyle.css">

    <title>Autenticação de Usuário</title>
</head>
<body>
    <?php
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
      
        include "../includes/conecta_bd.inc";
        include "../includes/encrypt.inc";
        include_once "../classes/Usuario.php";
        
        $query = "SELECT * FROM usuario WHERE nomeUsuario = '$usuario'";
        
        $resultado = mysqli_query($conexao, $query);
        
        $linhas = mysqli_num_rows($resultado);
        
        if($linhas == 0){
            echo "<h3>Usuário não encontrado!</h3>";
            echo "<p><button><a href=\"login.php\">Voltar</button></p>";
        }else{
            while($row = mysqli_fetch_array($resultado)){
                $res_senha = $row["senha"];
                $res_email = $row["email"];
                $res_usuario = $row["nomeUsuario"];
            }
            
            $senha = encryptPassword($res_usuario, $res_email, $senha);

            if($senha != $res_senha){
                echo "<h3>Senha incorreta!</h3>";
                echo "<p><button><a href=\"login.php\">Voltar</button></p>";
            }else{
                $idUsuario = Usuario::selectId($usuario);

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
                    
                header("Location: ./../Home.php");
            }
        }
      
        mysqli_close($conexao);
    ?>
</body>
</html>
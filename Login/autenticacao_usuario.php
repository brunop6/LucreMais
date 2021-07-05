<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autenticação de Usuário</title>
    <link rel="stylesheet" href="aparencial.css">
</head>
<body>
    <?php
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
      
        include "../includes/conecta_bd.inc";
        include "../includes/encrypt.inc";
        include_once "../classes/Usuario.php";
        
        $query = "select * from usuario where nomeUsuario = '$usuario'";
        
        $resultado = mysqli_query($conexao, $query);
        
        $linhas = mysqli_num_rows($resultado);
        
        if($linhas == 0){
            echo "Usuário não encontrado!";
            echo "<p><a href=\"login.php\">Voltar</p>";
        }else{
            while($row = mysqli_fetch_array($resultado)){
                $res_senha = $row["senha"];
                $res_email = $row["email"];
                $res_usuario = $row["nomeUsuario"];
            }
            
            $senha = encryptPassword($res_usuario, $res_email, $senha);

            if($senha != $res_senha){
                echo "Senha incorreta!";
                echo "<p><a href=\"login.php\">Voltar</p>";
            }else{
                $idUsuario = Usuario::selectId($usuario);
                $nivelAcesso = Usuario::selectNivel($idUsuario);
                
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
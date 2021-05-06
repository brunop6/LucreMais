<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autenticação de Usuário</title>
</head>
<body>
    <?php
      $usuario = $_POST["usuario"];
      $senha = $_POST["senha"];
      
      include "includes/conecta_bd.inc";
    
      $query = ("select * from usuarios where usuario = '$usuario'");
    
      $resultado = mysqli_query($conexao, $query);
    
      $linhas = mysqli_num_rows($resultado);
    
      if($linhas == 0){
          echo "Usuário não encontrado!";
          echo "<p><a href=\"login.php\">Voltar</p>";
      }else{
          while($row = mysqli_fetch_array($resultado)){
              $res_senha = $row["senha"];
          }
          
          if($senha != $res_senha){
              echo "Senha incorreta!";
              echo "<p><a href=\"login.php\">Voltar</p>";
          }else{
             // setcookie("nome_usuario",$usuario);
              //setcookie("senha_usuario",$senha);
            session_start();
            $_SESSION["nome_usuario"] = $usuario;
            $_SESSION["senha_usuario"] = $senha;
              
              header("Location: pagina_inicial.php");
          }
      }
      
      mysqli_close($conexao);
    ?>
</body>
</html>
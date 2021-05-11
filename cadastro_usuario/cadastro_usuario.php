<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
</head>
<body>
    <?php
        include '../includes/conecta_bd.inc';
        include '../includes/encrypt.inc';

        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $senha = encryptPassword($usuario, $email, $senha);

        $query = "INSERT INTO usuario VALUES (null, '$usuario', '$email', '$senha')";
        
        $result = mysqli_query($conexao, $query);

        if($result){
            echo '<h2>Cadastro realizado com sucesso!</h2>';
            echo "<p><a href='../login/login.html'><button>Retornar ao login</button></a></p>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo mysqli_error($conexao);
            echo "<p><a href='../login/login.html'><button>Retornar ao login</button></a></p>";  
        }
        mysqli_close($conexao);
    ?>
</body>
</html>
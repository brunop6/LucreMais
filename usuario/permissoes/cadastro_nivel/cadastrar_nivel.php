<?php
    if(!isset($_POST['descricao'])){
        header('Location: ./../permissoes.php');
        die();
    }else{
        include_once './../../../classes/Usuario.php';

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'];
        $descricao = $_POST['descricao'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../../Aparencia.css">
    <link rel="stylesheet" href="./../permissoes.css">

    <title>Cadastrar Novo Nível</title>
</head>
<body>
    <?php
        $resultado = Usuario::cadastrarNivel($idUsuario, $descricao);

        if(!$resultado){
            echo "<h3>Erro ao cadastrar nível de acesso: </h3>";
            echo "<p>$resultado</p>";
            echo "<button onclick='window.location.href='./../permissoes.php''>Retornar às permissões</button>";
        }

        if(isset($_POST['estoque'])){
            
        }
    ?>
</body>
</html>
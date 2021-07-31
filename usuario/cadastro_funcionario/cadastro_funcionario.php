<?php
    include './../../includes/validacao_cookies.inc';
    include_once './../../classes/Usuario.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $idUsuario = $_SESSION['id_usuario'];
    $nomeUsuario = $_SESSION['nome_usuario'];
    $nivelUsuario = $_SESSION['nivel_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    if ($nivelUsuario != "Administrador") {
        header('Location: ./../../../Home.php');
        die();
    }

    list($idNiveis, $descricaoNiveis) = Usuario::selectNiveisAcesso($emailUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro funcionário</title>
    <script type="text/javascript" src="./cadastro_funcionario.js"></script>
    <link rel="stylesheet" href="aparenciafuncionario.css">
</head>
<body>
    <?php
        if(empty($idNiveis)){
            echo '<h1>Cadastre um nível de acesso!</h1>';
            echo '<button><a href="./../permissoes/cadastro_nivel/cadastro_nivel.php">Novo Nível</a></button>';
            die();
        }
    ?>
    <img src="./../../public/img/Logo.png" alt="Logo do site" width="14%">
    <h1> Cadastro de Funcionário </h1>
       <form action="cadastrar_funcionario.php" method="POST">
            <p><input type="text" name="usuario" placeholder="Usuário" id="em" required></p>
            <p><input type="password" name="senha" placeholder="Senha" id="s" onchange="confirmar_senha()" required></p>
            <p><input type="password" placeholder="Confirme sua senha" id="sc" onkeyup="confirmar_senha()" required></p>
            <select name="nivel_de_acesso" id="niveldeacesso" required>
                <?php
                    $i = 0;
                    foreach($idNiveis as $idNivel){
                        echo "<option value='$idNivel'>$descricaoNiveis[$i]</option>";
                        $i++;
                    }
                ?>
            </select>
            <p><input type="submit" value="Cadastrar-se"> 
            <p><input type="button" value="Voltar" onclick="window.location.href='./../permissoes/permissoes.php'"></p>
       </form>
       
</body>
</html>
<?php
    include_once './../../includes/encrypt.inc';

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $nomeUsuario = $_SESSION['nome_usuario'];
?>  
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <script src="./../../public/js/confirmar_senha.js"></script>

    <link rel="stylesheet" href="./../../public/css/formStyle.css">
    
    <title>Edição de Usuário</title>
</head>
<body>
    <img src="./../../public/img/Logo.png" alt="Logo do Site" width="14%">
    <form action="./editar_usuario.php" method="POST">
        <h3>Edição de Usuário</h3>
        
        <p><input type="text" name="nome" placeholder="Nome" value="<?php echo $nomeUsuario ?>" required></p>
           
        <p><input type="password" name="senha" placeholder="Nova Senha" id="s" onchange="confirmar_senha()" required></p>
        <p><input type="password" placeholder="Confirme sua senha" id="sc" onkeyup="confirmar_senha()" required></p>

        <p><input type="submit" value="Salvar"></p>
        
        <p><input type="button" value="Voltar" onclick="window.location.href='./../../Home.php'"></p>
</form>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <script type="text/javascript" src="./cadastro_usuario.js"></script>
    <link rel="stylesheet" href="./../../Login/aparencial.css">
</head>
<body>
    <section class="cadastro">
        <form action="./cadastrar_usuario.php" method="POST">
            <img src="./../../public/img/Logo.png" alt="Logo do site" width="70%">
            <h1>Bem-vindo ao cadastramento "Lucre+"<br></h1>
            <h4>Rumo ao lucro certo, graças a escolha certa!</h4>
            <p><input type="text" name="usuario" placeholder="Usuário" id="em" required></p>
            <p><input type="email" name="email" placeholder="Email" required></p>
            <p><input type="password" name="senha" placeholder="Senha" id="s" onchange="confirmar_senha()" required></p>
            <p><input type="password" placeholder="Confirme sua senha" id="sc" onkeyup="confirmar_senha()" required></p>
            <p><input type="submit" value="Cadastrar-se"> 
        </form>
    </section>
</body>
</html>
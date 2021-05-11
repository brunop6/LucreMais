<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="./../Login/aparencial.css">
</head>
<body>
    <section class="cadastro">
        <form action="./cadastro_usuario.php" method="POST">
            <img src="./../Logo.png" alt="Logo do site" width="70%">
            <h1>Bem-vindo ao cadastramento "Lucre+"<br></h1>
            <h4>Rumo ao lucro certo, graças a escolha certa!</h4>
            <p><input type="text" name="usuario" placeholder="Usuário" id="em"></p>
            <p><input type="email" name="email" placeholder="Email"></p>
            <p><input type="password" name="senha" placeholder="Senha"></p>
            <p><input type="submit" value="Cadastrar-se"> 
        </form>
    </section>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./aparencial.css">
</head>
<body>
    <section class="login">
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <form action="" method="POST">
            <h2>Login</h2>
            <p><input type="email" name="email" placeholder="Email" id="em"></p>
            <p><input type="password" name="senha" placeholder="Senha"></p>
            <p><input type="button" value="Cadastrar-se" onclick="window.location.href='../cadastros/cadastrar_usuario.html'"> 
                <input type="submit" value="Entrar"></p>
        </form>
    </section>
</body>
</html>
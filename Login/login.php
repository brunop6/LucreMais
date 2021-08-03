<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="./../public/css/inputs.css">
    <link rel="stylesheet" href="./aparencial.css">

    <title>Login</title>
</head>
<body>
    <section class="login">
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <form action="./autenticacao_usuario.php" method="POST">
            <img src="./../public/img/Logo.png" alt="Logo do site" width="90%">
            <h2>Login</h2>
            <p><input type="text" name="usuario" placeholder="Usuário" id="em"></p>
            <p><input type="password" name="senha" placeholder="Senha"></p>
            <p>
                <input type="button" value="Cadastrar-se" onclick="window.location.href='./../usuario/cadastro_usuario/cadastro_usuario.php'"> 
                <input type="submit" value="Entrar">
            </p>
        </form>
    </section>
    <aside>
        <!-- Espaço para escrever a explicação do site, o que é o site? Para que serve? -->
        <h1 style="color: #B9DEFF;">Texto explicativo sobre o site</h1>
    </aside>
</body>
</html>
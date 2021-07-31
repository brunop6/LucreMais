<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro funcionário</title>
    <link rel="stylesheet" href="aparenciafuncionario.css">
</head>
<body>
<img src="./../public/img/Logo.png" alt="Logo do site" width="14%">
    <h1> Cadastro de Funcionário </h1>
       <form action="cadastrar_funcionario.php" method="POST">
            <p><input type="text" name="usuario" placeholder="Usuário" id="em" required></p>
            <p><input type="password" name="senha" placeholder="Senha" id="s" onchange="confirmar_senha()" required></p>
            <p><input type="password" placeholder="Confirme sua senha" id="sc" onkeyup="confirmar_senha()" required></p>
            <select name="nivel_de_acesso" id="niveldeacesso" required>
                <option value="nivel_de_acesso"> Nível de Acesso </option>
                <option value="administrador"> Administrador </option>
                <option value="estoquista"> Estoquista </option>
            </select>
            <p><input type="submit" value="Cadastrar-se"> 
            <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
       </form>
       
</body>
</html>
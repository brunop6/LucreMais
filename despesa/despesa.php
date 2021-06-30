<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Despesas</title>
    <link rel="stylesheet" href="despesa.css">
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">
    <!--<header>
    <input type="checkbox" id="btn-menu">
    <label for="btn-menu">&#9776;</label>
    <nav class="menu">
    <ul>
    <li><a href="../Home.php">Página Principal</a></li>
    </ul>
    </header>-->

    <form action="" method="POST">
    <h1><p>Despesas <input type="text" list="despesa"></p></h1>
    <datalist id="despesa" name="despesa">
    <option value="Água"></option>
    <option value="Luz"></option>
    <option value="Internet"></option>
    <option value="Funcionários"></option>
    <option value="Gás"></option>
    <option value="Compras"></option>
</datalist>
    <input type="text" name="valor" placeholder="R$">
    </form>
    <p><input type="submit" value="Confirmar"></p>
    <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
</body>
</html>
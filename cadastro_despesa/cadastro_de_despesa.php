<?php
  define('menu', 'Itens');
  include_once "../classes/Usuario.php";

  if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
  $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);

  if(!Usuario::verificarMenu($idUsuario, menu)){
      header("Location: ./../Home.php");
      die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./cadastro_despesa.js"></script>
    <title>Despesas</title>
    <link rel="stylesheet" href="despesa.css">
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">

    <form action="cadastrar_despesas.php" method="POST">
    <h1><p>Despesas <input type="text" name = "categoriaDespesa" id="categoriaDespesa" list="categorias" oninput="preencherCategorias()" required></p></h1>
    <datalist id="despesa" name="despesa">
    </datalist>
    <input type="text" name="valor" placeholder="R$">
   
    <p><input type="submit" value="Confirmar"></p>
    <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
    </form>
</body>
</html>



 <!--   <option value="Água" name="despesa"></option>
    <option value="Luz"></option>
    <option value="Internet"></option>
    <option value="Funcionários"></option>
    <option value="Gás"></option>
    <option value="Compras"></option> -->
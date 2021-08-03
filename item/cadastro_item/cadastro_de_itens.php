<?php
  define('menu', 'Itens');
  include_once "../../classes/Usuario.php";

  if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
  $idUsuario = $_SESSION['id_usuario'];

  if(!Usuario::verificarMenu($idUsuario, menu)){
      header("Location: ./../../Home.php");
      die();
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./../../public/js/datalists.js"></script>
    <script type="text/javascript" src="./cadastro_item.js"></script>

    <link rel="stylesheet" href="./../../public/css/formStyle.css">

    <title>Cadastro de Itens</title>
</head>
<body>
  
  <img src="./../../public/img/Logo.png" alt="Logo do site" width="14%">
  <h1>Cadastrar Itens<br></h1>
  <section class="cadastro">
  
  <form action="cadastrar_itens.php" method="POST">
  
    <p><input type="text" name="nome" placeholder="Nome do Item" required></p>
    <p><input type="text" name="marca" placeholder="Marca" required></p>
    
    <p><input type="text" name="categoria" placeholder="Tipo de item" id="categoria" list="categorias" oninput="preencherCategorias()" required></p>
      <datalist id="categorias">
      
      </datalist>
    <p><input type="number" name="quantidade" placeholder="Quantidade" step="0.1" required></p>
   
    <select name="unidade_de_medida" id="unidadeMedida" required>
    
    <option value="unidade_de_medida" onkeyup="validar_unidade_medida()">Unidade de Medida</option>
      <option value="unidade(s)">Unidade(s)</option>
      <option value="litro(s)">Litro(s)</option> 
      <option value="ml">ml</option>
      <option value="quilo(s)">Quilo(s)</option>
      <option value="gramas">Gramas</option>
      <option value="colher_de_sopa" >Colher de Sopa</option>
      <option value="colher_de_cha" >Colher de Chá</option>
      <option value="colher_de_cafe">Colher de Café</option>
      <option value="xicara">Xícara</option>
    </select>
   
   
    <p><input type="number" name="quantidadeMinima" placeholder="Quant. Mínima" step="0.1" onfocus="validar_unidade_medida()" required></p>

   

    <p><input type="submit" value="Cadastrar Item"></p>

    <p><input type="button" value="Voltar" onclick="window.location.href='./../item.php'"></p>
  </form>
  </section>
</body>  
</html>
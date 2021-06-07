<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Itens</title>
    <script type="text/javascript" src="./cadastro_item.js"></script>
    <link rel="stylesheet" href="aparenciaitem.css">
    <?php
      include "../includes/conecta_bd.inc";
      include_once '../classes/Fornecedor.php';
      include_once '../classes/Categoria.php';

      function atualizarFornecedores(){
        $fornecedores = Fornecedor::selectFornecedores();

        if(!empty($fornecedores)){
          foreach($fornecedores as $value){
            echo "<option value='$value'></option>";
          }
        }
      }

      function atualizarCategorias(){
        $categorias = Categoria::selectCategorias();

        if(!empty($categorias)){
          foreach($categorias as $value){
            echo "<option value='$value'></option>";
          }
        }
      }
    ?>
</head>
<body>
  
  <img src="./../Logo.png" alt="Logo do site" width="14%">
  <h1>Cadastrar Itens<br></h1>
  <section class="cadastro">
  
  <form action="cadastrar_itens.php" method="POST" onSubmit = "validar_unidade_medida()" >
  
    <p><input type="text" name="nome" placeholder="Nome do Item" required></p>
    <p><input type="text" name="marca" placeholder="Marca" required></p>
    
    <p><input type="text" name="categoria" placeholder="Tipo de item" list="categorias" required></p>
    <datalist id="categorias">
      <?php
        echo atualizarCategorias();
      ?>
    </datalist>

    <p><input type="number" name="quantidade" placeholder="Quantidade" step="0.1" required></p>
   
    <select name="unidade_de_medida" required>
    
    <option value="unidade_de_medida">Unidade de Medida</option>
      <option value="unidade">Unidade</option> 
      <option value="ml" >ML</option>
      <option value="grama"  >Grama</option>
      <option value="colher_de_sopa" >Colher de Sopa</option>
      <option value="colher_de_cha" >Colher de Chá</option>
      <option value="colher_de_cafe">Colher de Café</option>
      <option value="xicara">Xícara</option>
    </select>
   
   
    <p><input type="number" name="quantidadeMinima" placeholder="Quant. Mínima" step="0.1" required></p>

   

    <p><input type="submit" value="Cadastrar Item"></p>

    <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
  </form>
  </section>
</body>  
</html>
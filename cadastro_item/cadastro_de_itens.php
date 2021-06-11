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
          $i = 0;
          foreach($categorias as $value){
            $json[] = $value;
            $i++;
          }
        }
        echo json_encode($json);
      }
    ?>
    <script>
      function atualizarCategorias(){
        var inputCategoria = document.getElementById('categoria').value;

        if(inputCategoria.length >= 3){
          var categoria = <?php atualizarCategorias() ?>;
          var datalist = document.getElementById('categorias');
          var options = datalist.children; //Elementos filhos do datalist categorias
          var option = [];
          
          for1:
          for(var i = 0; i < categoria.length; i++){
            for2:
            for(var j = 0; j < options.length; j++){
              /**
               * Se a categoria a ser apresentada for igual a uma categoria já apresentada nas opções anteriores
               * a adição não sera refeita
               */
              if(categoria[i] == options[j].value) break for1;
            }
            
            option[i] = document.createElement('option');
            option[i].value = categoria[i];
            option[i].id = 'opt';
            datalist.appendChild(option[i]);
          }
        }else{
          document.getElementById('opt').remove();
        }
      }
    </script>
</head>
<body>
  
  <img src="./../Logo.png" alt="Logo do site" width="14%">
  <h1>Cadastrar Itens<br></h1>
  <section class="cadastro">
  
  <form action="cadastrar_itens.php" method="POST">
  
    <p><input type="text" name="nome" placeholder="Nome do Item" required></p>
    <p><input type="text" name="marca" placeholder="Marca" required></p>
    
    <p id="pCategoria"><input type="text" name="categoria" placeholder="Tipo de item" id="categoria" list="categorias" oninput="atualizarCategorias()" required></p>
      <datalist id="categorias">
      
      </datalist>
    <p><input type="number" name="quantidade" placeholder="Quantidade" step="0.1" required></p>
   
    <select name="unidade_de_medida" id="unidadeMedida" required>
    
    <option value="unidade_de_medida" onkeyup="validar_unidade_medida()">Unidade de Medida</option>
      <option value="unidade(s)">Unidade(s)</option>
      <option value="litro(s)">Litro(s)</option> 
      <option value="ml">ml</option>
      <option value="gramas">Gramas</option>
      <option value="colher_de_sopa" >Colher de Sopa</option>
      <option value="colher_de_cha" >Colher de Chá</option>
      <option value="colher_de_cafe">Colher de Café</option>
      <option value="xicara">Xícara</option>
    </select>
   
   
    <p><input type="number" name="quantidadeMinima" placeholder="Quant. Mínima" step="0.1" onfocus="validar_unidade_medida()" required></p>

   

    <p><input type="submit" value="Cadastrar Item"></p>

    <p><input type="button" value="Voltar" onclick="window.location.href='./../Home.php'"></p>
  </form>
  </section>
</body>  
</html>
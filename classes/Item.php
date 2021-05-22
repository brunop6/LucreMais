<?php
  include '../includes/conecta_bd.inc';
  Class Item {
      private idUsuario;
      private idFornecedor;
      private idCategoria;
      private nome;
      private quantidade;
      private unidadeMedida;
      private preco;
      private quantMinima;
      private lote;
      private statusItem;

      function __construct($idUsuario,  $idFornecedor, $idCategoria, $nome, $quantidade,$unidadeMedida,$preco,$quantMinima,$lote, $statusItem){
        $this->idUsuario = $idUsuario;
        $this->idFornecedor = $idFornecedor;
        $this->idCategoria = $idCategoria;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->unidadeMedida = $unidadeMedida;
        $this->preco = $preco;
        $this->quantMinima = $quantMinima;
        $this->lote = $lote;
        $this->statusItem = $statusItem; 

      }

        function cadastrar_item(){
  

        $query = "INSERT INTO item VALUES (null,'$this->idUsuario','$this->idFornecedor','$this->idCategoria','$this->nome', '$this->quantidade', '$this->unidadeMedida', '$this->preco', '$this->quantMinima', '$this->lote','$this->statusItem',  null,  null)";
        
        $resultado = mysqli_query($conexao, $query);

        if($resultado){
            echo '<h2>Cadastro realizado com sucesso!</h2>';
            echo "<p><a href='Cadastro/cadastro_de_itens'><button>Cadastrar novo item</button></a></p>";
            echo "<p><a href='Login/login.php'><button>Voltar para página inicial</button></a></p>";
        }else{
            echo '<h2>Erro ao realizar cadastro...</h2> <br>';
            echo "<p lang='en'>".mysqli_error($conexao)."</p>";
            echo "<p><a href='Cadastro/cadastro_de_itens'><button>Retornar ao cadastro de itens</button></a></p>";  
        }
        mysqli_close($conexao);


      }

   /*   public function editar_item(){
       
        $query = ("select idUsuario, idFornecedor, idCategoria, nome, quantidade, unidadeMedida, preco, quantMinima, lote, statusItem  from item where id = $this->id");
    
        $resultado = mysqli_query($conexao, $query);
    
        while($row = mysqli_fetch_array($resultado)){
        $id= $row["id"];
        $idUsuario = $row["idUsuario"];
        $idFornecedor = $row["idFornecedor"];
        $idCategoria = $row["idCategoria"];
        $nome = $row["nome"];
        $quantidade = $row["quantidade"];
        $unidadeMedida = $row["unidadeMedida"];
        $preco = $row["preco"];
        $quantMinima = $row["quantMinima"];
        $lote = $row["lote"];
        $statusItem = $row['statusItem'];

      }

    /*  public function excluir_item(){
        $query = ("delete from item where id = $id");
    
        $resultado = mysqli_query($conexao,$query);
        
        if($resultado){
            echo "<center>Item excluído com sucesso!</center>";
        }else{
            echo "<center>Erro ao excluir item!</center>";
        }
      }
      */  

    /*  public function status_item($id = null){
        $query = ("select idUsuario, idFornecedor, idCategoria, nome, quantidade, unidadeMedida, preco, quantMinima, lote, status  from item where id = $this->id");
        if($query != null){
          if($query->ativo == 1){
            $dados['ativo' = 0];
          }else{
            $dados['ativo'] = 1;
          }
        }else{
          redirect('/');
        }
        */



        


        
        
      }
  }
?>
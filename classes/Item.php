<?php
  class Item {
    private $idUsuario;
    private $idFornecedor;
    private $idCategoria;
    private $nome;
    private $quantidade;
    private $unidadeMedida;
    private $preco;
    private $quantMinima;
    private $lote;
    private $statusItem;

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
      include '../includes/conecta_bd.inc';

      //Para acrescentar: idFornecedor e idCategoria
      $query = "INSERT INTO item (idUsuario, nome, quantidade, unidadeMedida, preco, quantidadeMinima, lote, status) VALUES ($this->idUsuario,'$this->nome', $this->quantidade, '$this->unidadeMedida', $this->preco, $this->quantMinima, $this->lote,'$this->statusItem')";
      
      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return 'Cadastro realizado com sucesso!';
      }

      return mysqli_error($conexao);
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
    }
      */     
  }
?>
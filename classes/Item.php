<?php
  class Item {
    
    private $idUsuario;
    private $idCategoria;
    private $marca;
    private $nome;
    private $quantidade;
    private $unidadeMedida;
    private $quantidadeMinima;

    function __construct($idUsuario, $idCategoria, $marca, $nome, $quantidade,$unidadeMedida, $quantidadeMinima){
      
      $this->idUsuario = $idUsuario;
      $this->idCategoria = $idCategoria;
      $this->marca = $marca;
      $this->marca = mb_strtoupper($marca);
      $this->nome = $nome;
      $this->nome = mb_strtoupper($nome);
      $this->quantidade = $quantidade;
      $this->unidadeMedida = $unidadeMedida;
      $this->unidadeMedida = mb_strtoupper($unidadeMedida);
      $this->quantidadeMinima = $quantidadeMinima;
    }

    public static function selectId($nome, $marca){
      include '../includes/conecta_bd.inc';
      
      $query = "SELECT id FROM item WHERE nome = '$nome' and marca = '$marca'";

      $resultado = mysqli_query($conexao, $query);
      
      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $id = $row['id'];
        }
      }
    
      mysqli_close($conexao);
      
      return $id;
    }
  public static function selectItens(){
    include '../includes/conecta_bd.inc';

    $query = "SELECT nome, marca FROM item";

    $resultado = mysqli_query($conexao, $query);
    $marca = null;
    $nome = null;
    if(mysqli_num_rows($resultado) > 0){
        $i = 0;
        while($row = mysqli_fetch_array($resultado)){
            $marca[$i]= $row['marca'];
            $nome[$i] = $row['nome'];
            $i++;
        }
    }
    mysqli_close($conexao);

    return array ($marca,$nome);
  }
<<<<<<< HEAD


  public static function selectItensLista(){
    include '../includes/conecta_bd.inc';

    $query = "SELECT id, nome, quantidade, idCategoria, quantidadeMinima, idUsuario FROM item  ";

    $resultado = mysqli_query($conexao, $query);
    $id = null;
    $quantidade = null;
    $nome = null;
    $idCategoria = null;
    $quantidadeMinima = null;
    $idUsuario = null;
    if(mysqli_num_rows($resultado) > 0){
        $i = 0;
        while($row = mysqli_fetch_array($resultado)){
            $id[$i] = $row['id'];
            $nome[$i] = $row['nome'];
            $quantidade[$i]= $row['quantidade'];
            $idCategoria[$i] = $row['idCategoria'];
            $quantidadeMinima[$i] = $row['quantidadeMinima'];
            $idUsuario[$i] = $row['idUsuario'];
            $i++;
        }
    }
    mysqli_close($conexao);

    return array ($id, $nome,$quantidade,$idCategoria,$quantidadeMinima, $idUsuario);
  }
  


public static function selectItem($busca){
  include '../includes/conecta_bd.inc';
  $id = $_GET['id'];
  $query = "SELECT nome, marca FROM item WHERE nome LIKE'%$busca%' OR marca LIKE'%$busca%'";
=======

  public static function selectItem($busca){
    include '../includes/conecta_bd.inc';

    $query = "SELECT nome, marca FROM item WHERE nome LIKE'%$busca%' OR marca LIKE'%$busca%'";
>>>>>>> 59f196caa205ef0abb72fe53f12b8862ded75fbd

    $resultado = mysqli_query($conexao, $query);
    $marca = null;
    $nome = null;
    if(mysqli_num_rows($resultado) > 0){
      $i = 0;
      while($row = mysqli_fetch_array($resultado)){
        $marca[$i]= $row['marca'];
        $nome[$i] = $row['nome'];
        $i++;
      }
    }
    mysqli_close($conexao);

    return array ($marca,$nome);
  }
 
  public function cadastrar_item(){
    include '../includes/conecta_bd.inc';

    //Para acrescentar: idFornecedor e idCategoria
    $query = "INSERT INTO item (idUsuario, idCategoria, marca, nome, quantidade, unidadeMedida, quantidadeMinima) VALUES ('$this->idUsuario','$this->idCategoria','$this->marca','$this->nome', '$this->quantidade', '$this->unidadeMedida','$this->quantidadeMinima')";
    
    $resultado = mysqli_query($conexao, $query);

    if($resultado){
        return 'Cadastro realizado com sucesso!';
    }
<<<<<<< HEAD
  
    
   public function editar_item($id){
    include '../includes/conecta_bd.inc';
      $id = $_GET['id'];
       $query = "UPDATE item 
      SET marca = '$this->marca', nome = '$this->nome', idCategoria = '$this->idCategoria',
      quantidade = '$this->quantidade',
      unidadeMedida = '$this->unidadeMedida', quantidadeMinima ='$this->quantidadeMinima' WHERE id = '$id'";
   //  $query = "UPDATE item SET nome = '$this->nome'"; 

    $resultado = mysqli_query($conexao, $query);

    if($resultado){
    return true;
=======

    return mysqli_error($conexao);
  }

  public function editar_item(){
    include '../includes/conecta_bd.inc';
      
    $query = "UPDATE item 
    SET idCategoria = '$idCategoria', marca = '$marca', nome = '$nome', quantidade = '$quantidade',
      unidadeMedida = $unidadeMedida, quantidadeMinima = $quantidadeMinima  
    where id = $this->id";

    $resultado = mysqli_query($conexao, $query);

    while($row = mysqli_fetch_array($resultado)){
      $id= $row["id"];
      $idUsuario = $row["idUsuario"];
      $idCategoria = $row["idCategoria"];
      $marca = $row["marca"];
      $nome = $row["nome"];
      $quantidade = $row["quantidade"];
      $unidadeMedida = $row["unidadeMedida"];
      $quantidadeMinima = $row["quantidadeMinima"];
>>>>>>> 59f196caa205ef0abb72fe53f12b8862ded75fbd
    }
    if($resultado){
      return 'Edição realizada com sucesso!';
    } 
    return mysqli_error($conexao);
<<<<<<< HEAD
      
  }
  
  }
?>    
=======
  }

  public function excluir_item(){
    include '../includes/conecta_bd.inc';
    $query = "delete from item where id = $id";

    $resultado = mysqli_query($conexao ,$query);
    
    if($resultado){
        echo "<center>Item excluído com sucesso!</center>";
    }else{
        echo "<center>Erro ao excluir item!</center>";
    }
  }
  public function listar_item(){
    $query = "select * from item";
  } 
}
?>
>>>>>>> 59f196caa205ef0abb72fe53f12b8862ded75fbd

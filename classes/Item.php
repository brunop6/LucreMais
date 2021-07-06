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

    public static function selectId($nome, $marca, $email){
      include '../includes/conecta_bd.inc';
      
      $query = "SELECT i.id 
      FROM item i, usuario u
      WHERE i.nome = '$nome' 
        AND i.marca = '$marca'
        AND i.idUsuario = u.id
        AND u.email = '$email'";

      $resultado = mysqli_query($conexao, $query);
      
      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $id = $row['id'];
        }
      }
    
      mysqli_close($conexao);
      
      return $id;
    }

    public static function selectItens($email){
      include '../includes/conecta_bd.inc';

      $query = "SELECT i.nome, i.marca 
      FROM item i, usuario u
      WHERE u.id = i.idUsuario
        AND u.email = '$email'";

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

      return array($marca, $nome);
    }

    public static function selectItensLista($email){
      include '../includes/conecta_bd.inc';

      $query = "SELECT i.id, i.nome, i.marca, i.quantidade, i.quantidadeMinima, i.unidadeMedida, u.nomeUsuario, c.descricaoCategoria 
      FROM item i, usuario u, categoria c 
      WHERE c.id = i.idCategoria 
        AND i.idUsuario = u.id
        AND u.email = '$email'";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $item = null;
      $quantidade = null;
      $descricaoCategoria = null;
      $quantidadeMinima = null;
      $unidadeMedida = null;
      $nomeUsuario = null;
      if(mysqli_num_rows($resultado) > 0){
        $i = 0;
        while($row = mysqli_fetch_array($resultado)){
          $id[$i] = $row['id'];
          $item[$i] = $row['nome'].' '.$row['marca'];
          $quantidade[$i]= $row['quantidade'];
          $descricaoCategoria[$i] = $row['descricaoCategoria'];
          $quantidadeMinima[$i] = $row['quantidadeMinima'];
          $unidadeMedida[$i] = $row['unidadeMedida'];
          $nomeUsuario[$i] = $row['nomeUsuario'];
          $i++;
        }
      }
      mysqli_close($conexao);

      return array($id, $item, $quantidade, $descricaoCategoria, $quantidadeMinima, $unidadeMedida, $nomeUsuario);
    }
    public static function selectItemLista($id){
      include '../includes/conecta_bd.inc';

      $query = "SELECT i.nome, i.marca, i.quantidade, i.quantidadeMinima, c.descricaoCategoria 
      FROM item i, usuario u, categoria c 
      WHERE c.id = i.idCategoria 
        AND i.idUsuario = u.id 
        AND i.id = $id";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $nome = null;
      $marca = null;
      $quantidade = null;
      $descricaoCategoria = null;
      $quantidadeMinima = null;
      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $nome = $row['nome'];
          $marca = $row['marca'];
          $quantidade = $row['quantidade'];
          $descricaoCategoria = $row['descricaoCategoria'];
          $quantidadeMinima = $row['quantidadeMinima'];
        }
      }
      mysqli_close($conexao);

      return array($nome, $marca, $quantidade, $descricaoCategoria, $quantidadeMinima);
    }

    public static function selectItem($busca, $email){
      include '../includes/conecta_bd.inc';

      $query = "SELECT DISTINCT i.nome, i.marca 
      FROM item i, usuario u
      WHERE i.nome LIKE'%$busca%' OR i.marca LIKE'%$busca%'
        AND u.id = i.idUsuario
        AND u.email = '$email'";

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

      return array($marca, $nome);
    }
 
    public function cadastrar_item(){
      include '../includes/conecta_bd.inc';

      $query = "INSERT INTO item (idUsuario, idCategoria, marca, nome, quantidade, unidadeMedida, quantidadeMinima) VALUES ('$this->idUsuario','$this->idCategoria','$this->marca','$this->nome', '$this->quantidade', '$this->unidadeMedida','$this->quantidadeMinima')";
      
      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return 'Cadastro realizado com sucesso!';
      }
      return mysqli_error($conexao);
    }    

    public function editar_item($id){
      include '../includes/conecta_bd.inc';
      
      $query = "UPDATE item 
      SET  marca = '$this->marca', nome = '$this->nome', idCategoria = $this->idCategoria, quantidade = $this->quantidade, unidadeMedida = '$this->unidadeMedida', quantidadeMinima =$this->quantidadeMinima 
      WHERE id = $id";

      $resultado = mysqli_query($conexao, $query);

      if($resultado){
        return true;
      } 
      return mysqli_error($conexao);
    }
  }
?>    

<?php
  class Entrada{
    private $idUsuario;
    private $idCategoriaEntrada;
    private $valor;

    function __construct($idUsuario, $idCategoriaEntrada, $valor){
      $this->idUsuario = $idUsuario;
      $this->idCategoriaEntrada = $idCategoriaEntrada;
      $this->valor = $valor;
    }

    public function cadastrar_entrada(){

      include __DIR__.'./../includes/conecta_bd.inc';
      
      $query = "INSERT INTO entrada (idUsuario, idCategoriaEntrada, valor) VALUES ('$this->idUsuario', '$this->idCategoriaEntrada', '$this->valor')";
      
      $resultado = mysqli_query($conexao, $query);
      if($resultado){
        return "Cadastro realizado com sucesso!";
      }
      return mysqli_error($conexao);        
    }

    public function editar_entrada($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "UPDATE entrada
      SET  idCategoriaEntrada = '$this->idCategoriaEntrada', valor = '$this->valor'
      WHERE id = $id";

      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return true;
      }else{
          return mysqli_error($conexao);
      }
    }

    public static function selectEntradaLista($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT e.id, e.valor, u.nomeUsuario, c.descricao 
      FROM entrada e, usuario u, categoriaentrada c 
      WHERE c.id = e.idCategoriaEntrada 
        AND e.idUsuario = u.id
        AND u.email = '$email'";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $descricao = null;
      $valor = null;
      $nomeUsuario = null;

      if(mysqli_num_rows($resultado) > 0){
        $i = 0;
        while($row = mysqli_fetch_array($resultado)){
          $id[$i] = $row['id'];
          $descricao[$i] = $row['descricao'];
          $valor[$i] = number_format($row['valor'], 2);
          $nomeUsuario[$i] = $row['nomeUsuario'];
          $i++;
        }
      }
      mysqli_close($conexao);

      return array($id, $descricao, $valor, $nomeUsuario);
    }

    public static function selectEntradasLista($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT e.valor, ce.descricao, u.nomeUsuario
      FROM entrada e, usuario u, categoriaentrada ce
      WHERE ce.id = e.idCategoriaEntrada 
        AND e.idUsuario = u.id 
        AND e.id = $id";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $valor = null;
      $descricao = null;
      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $valor = number_format($row['valor'], 2);
          $descricao = $row['descricao'];
        }
      }
      mysqli_close($conexao);

      return array($descricao, $valor);
    }

    public static function selectTotal($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT SUM(e.valor) as total
      FROM entrada e, usuario u
      WHERE MONTH(e.dataCadastro) = (
          SELECT DATE_FORMAT(CURRENT_TIMESTAMP(), '%m')
        )
        AND e.idUsuario = u.id
        AND u.email = '$email'
      ";

      $resultado = mysqli_query($conexao, $query);

      $total = null;

      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $total = $row['total'];
        }
      }
      mysqli_close($conexao);

      return $total;
    }
  }

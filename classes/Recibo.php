<?php
  class Recibo{
    private $idUsuario;
    private $idCategoriaRecibo;
    private $valor;

    function __construct($idUsuario, $idCategoriaRecibo, $valor){
      $this->idUsuario = $idUsuario;
      $this->idCategoriaRecibo = $idCategoriaRecibo;
      $this->valor = $valor;
    }

    public function cadastrar_recibo(){

      include __DIR__.'./../includes/conecta_bd.inc';
      
      $query = "INSERT INTO recibo (idUsuario, idCategoriaRecibo, valor) VALUES ('$this->idUsuario', '$this->idCategoriaRecibo', '$this->valor')";
      
      $resultado = mysqli_query($conexao, $query);
      if($resultado){
        return "Cadastro realizado com sucesso!";
      }
      return mysqli_error($conexao);        
    }

    public function editar_recibo($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "UPDATE recibo
      SET  idCategoriaRecibo = '$this->idCategoriaRecibo', valor = '$this->valor'
      WHERE id = $id";

      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return true;
      }else{
          return mysqli_error($conexao);
      }
    }

    public static function selectReciboLista($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT r.id, r.valor, u.nomeUsuario, c.descricao 
      FROM recibo r, usuario u, categoriarecibo c 
      WHERE c.id = r.idCategoriaRecibo 
        AND r.idUsuario = u.id
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

    public static function selectRecibosLista($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT r.valor, cr.descricao, u.nomeUsuario
      FROM recibo r, usuario u, categoriarecibo cr 
      WHERE cr.id = r.idCategoriaRecibo 
        AND r.idUsuario = u.id 
        AND r.id = $id";

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
  }

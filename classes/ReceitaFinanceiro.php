<?php
  class ReceitaFinanceiro{
    private $idUsuario;
    private $idCategoriareceitaFinanceiro;
    private $valor;

    function __construct($idUsuario, $idCategoriareceitaFinanceiro, $valor){
      $this->idUsuario = $idUsuario;
      $this->idCategoriareceitaFinanceiro = $idCategoriareceitaFinanceiro;
      $this->valor = $valor;
    }

    public function cadastrar_receita(){

      include __DIR__.'./../includes/conecta_bd.inc';
      
      $query = "INSERT INTO receitafinanceiro (idUsuario, idCategoriareceitaFinanceiro, valor) VALUES ('$this->idUsuario', '$this->idCategoriareceitaFinanceiro', '$this->valor')";
      
      $resultado = mysqli_query($conexao, $query);
      if($resultado){
        return "Cadastro realizado com sucesso!";
      }
      return mysqli_error($conexao);        
    }

    public function editar_receita($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "UPDATE receitafinanceiro
      SET  idCategoriareceitaFinanceiro = '$this->idCategoriareceitaFinanceiro', valor = '$this->valor'
      WHERE id = $id";

      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return true;
      }else{
          return mysqli_error($conexao);
      }
    }

    public static function selectReceitasMes($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT r.id, r.valor, u.nomeUsuario, c.descricao 
      FROM receitafinanceiro r, usuario u, categoriareceitafinanceiro c 
      WHERE c.id = r.idCategoriareceitaFinanceiro
        AND r.idUsuario = u.id
        AND u.email = '$email'
        AND MONTH(r.dataCadastro) = MONTH(CURRENT_DATE)";

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

    public static function selectReceita($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT r.valor, c.descricao, u.nomeUsuario
      FROM receitafinanceiro r, usuario u, categoriareceitafinanceiro c
      WHERE c.id = r.idCategoriareceitaFinanceiro
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

    public static function selectTotalMes($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT SUM(r.valor) as total
      FROM receitafinanceiro r, usuario u
      WHERE MONTH(r.dataCadastro) = (
          SELECT DATE_FORMAT(CURRENT_TIMESTAMP(), '%m')
        )
        AND r.idUsuario = u.id
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

    public static function selectUltimosMeses($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT SUM(r.valor) as total, MONTH(r.dataCadastro) AS mes
      FROM receitafinanceiro r, usuario u
      WHERE r.idUsuario = u.id
        AND u.email = '$email'
        AND MONTH(r.dataCadastro) > (MONTH(CURRENT_DATE)-5)
      GROUP BY MONTH(r.dataCadastro)
      ORDER BY MONTH(r.dataCadastro)";

      $resultado = mysqli_query($conexao, $query);

      $totais = null;
      $meses = null;

      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $totais[] = $row['total'];
          $meses[] = $row['mes'];
        }
      }
      mysqli_close($conexao);

      return array($totais, $meses);
    }
  }

<?php
  class Despesa{
    private $idUsuario;
    private $idCategoriaDespesa;
    private $custo;

    function __construct($idUsuario, $idCategoriaDespesa, $custo){
      $this->idUsuario = $idUsuario;
      $this->idCategoriaDespesa = $idCategoriaDespesa;
      $this->custo = $custo;
    }

    public function cadastrar_despesa(){
      include __DIR__.'./../includes/conecta_bd.inc';
      
      $query = "INSERT INTO despesa (idUsuario, idCategoriaDespesa, custo) VALUES ('$this->idUsuario', '$this->idCategoriaDespesa', '$this->custo')";
      
      $resultado = mysqli_query($conexao, $query);
      if($resultado){
        return "Cadastro realizado com sucesso!";
      }
      return mysqli_error($conexao);        
    }

    public function editar_despesa($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "UPDATE despesa
      SET  idCategoriaDespesa = '$this->idCategoriaDespesa', custo = '$this->custo'
      WHERE id = $id";

      $resultado = mysqli_query($conexao, $query);

      if($resultado){
          return true;
      }else{
          return mysqli_error($conexao);
      }
    }

    public static function selectDespesasMes($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT d.id, d.custo, u.nomeUsuario, c.descricao 
      FROM despesa d, usuario u, categoriadespesa c 
      WHERE c.id = d.idCategoriaDespesa 
        AND d.idUsuario = u.id
        AND u.email = '$email'
        AND MONTH(d.dataCadastro) = MONTH(CURRENT_DATE)";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $descricao = null;
      $custo = null;
      $nomeUsuario = null;

      if(mysqli_num_rows($resultado) > 0){
        $i = 0;
        while($row = mysqli_fetch_array($resultado)){
          $id[$i] = $row['id'];
          $descricao[$i] = $row['descricao'];
          $custo[$i] = number_format($row['custo'], 2);
          $nomeUsuario[$i] = $row['nomeUsuario'];
          $i++;
        }
      }
      mysqli_close($conexao);

      return array($id, $descricao, $custo, $nomeUsuario);
    }

    public static function selectDespesa($id){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT d.custo, cd.descricao, u.nomeUsuario
      FROM despesa d, usuario u, categoriadespesa cd WHERE cd.id = d.idCategoriaDespesa AND d.idUsuario = u.id AND d.id = $id";

      $resultado = mysqli_query($conexao, $query);

      $id = null;
      $custo = null;
      $descricao = null;
      if(mysqli_num_rows($resultado) > 0){
        while($row = mysqli_fetch_array($resultado)){
          $custo = number_format($row['custo'], 2);
          $descricao = $row['descricao'];
        }
      }
      mysqli_close($conexao);

      return array($descricao, $custo);
    }

    public static function selectTotalMes($email){
      include __DIR__.'./../includes/conecta_bd.inc';

      $query = "SELECT SUM(d.custo) as total
      FROM despesa d, usuario u
      WHERE MONTH(d.dataCadastro) = (
          SELECT DATE_FORMAT(CURRENT_TIMESTAMP(), '%m')
        )
        AND d.idUsuario = u.id
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

      $query = "SELECT SUM(d.custo) as total, MONTH(d.dataCadastro) AS mes
      FROM despesa d, usuario u
      WHERE d.idUsuario = u.id
        AND u.email = '$email'
        AND MONTH(d.dataCadastro) > (MONTH(CURRENT_DATE)-5)
      GROUP BY MONTH(d.dataCadastro)
      ORDER BY MONTH(d.dataCadastro)";

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

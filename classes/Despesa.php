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

        include '../includes/conecta_bd.inc';
        
        $query = "INSERT INTO despesa (idUsuario, idCategoriaDespesa, custo) VALUES ('$this->idUsuario', '$this->idCategoriaDespesa', '$this->custo')";
       
        $resultado = mysqli_query($conexao, $query);
          if($resultado){
              return "Cadastro realizado com sucesso!";
          }else{
              return mysqli_error($conexao);
          }
        
    }

    public function editar_despesa($id){
      include '../includes/conecta_bd.inc';
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

    public static function selectDespesaLista(){
        include '../includes/conecta_bd.inc';
  
        $query = "SELECT d.id, d.custo, u.nomeUsuario, c.descricao 
        FROM despesa d, usuario u, categoriadespesa c WHERE c.id = d.idCategoriaDespesa AND d.idUsuario = u.id";
  
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
            $custo[$i] = $row['custo'];
            $nomeUsuario[$i] = $row['nomeUsuario'];
            $i++;
          }
        }
        mysqli_close($conexao);
  
        return array($id, $descricao, $custo, $nomeUsuario);
      }

      public static function selectDespesasLista($id){
        include '../includes/conecta_bd.inc';
  
        $query = "SELECT d.custo, cd.descricao, u.nomeUsuario
        FROM despesa d, usuario u, categoriadespesa cd WHERE cd.id = d.idCategoriaDespesa AND d.idUsuario = u.id AND d.id = $id";
  
        $resultado = mysqli_query($conexao, $query);
  
        $id = null;
        $custo = null;
        $descricao = null;
        if(mysqli_num_rows($resultado) > 0){
          while($row = mysqli_fetch_array($resultado)){
            $custo = $row['custo'];
            $descricao = $row['descricao'];
          }
        }
        mysqli_close($conexao);
  
        return array($descricao, $custo);
      }
  
}
?>
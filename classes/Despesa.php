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
        $query = "UPDATE despesa SET idCategoria' $this->idCategoria', custo '$this->custo' WHERE id = $id";

        $resultado = mysqli_query($conexao, $resultado);
        if($resultado){
            return true;
        }else{
            return mysqli_error($conexao);
        }
    }

    public function excluir_despesa($id){
        $query = "DELETE * FROM despesa WHERE id = $id";

        $resultado = mysqli_query($conexao, $resultado);
        if($resultado){
            return true;
        }else{
            return mysqli_error($conexao);
        }
    }

    public function claculaLucro($custo, $){

    }
}
?>
<?php
    class Receita{
        private $nomeReceita;

        function __construct($nomeReceita)
        {
            $this->nomeReceita = $nomeReceita;
        }

        public static function selectReceita(){
            include '../includes/conecta_bd.inc';

            $query = "SELECT nomeReceita FROM receita";

            $resultado = mysqli_query($conexao, $query);
            $nomeReceita = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeReceita[$i] = $row['nomeReceita'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $nomeReceita;
        }

        public static function selectId($nomeReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT id FROM receita WHERE nomeReceita = '$nomeReceita'";

            $resultado = mysqli_query($conexao, $query);
            
            $id = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $id = $row['id'];
                }
            }

            mysqli_close($conexao);

            return $id;
        }

        public function cadastrarReceita(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO receita (nomeReceita) VALUES ('$this->nomeReceita')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
        
        public static function verificaItem($idItem, $idReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT unidadeMedida, quantidade FROM item WHERE id = '$idItem'";

            $resultado = mysqli_query($conexao, $query);
            
            $unimedItem = null;
            $quantidadeItem = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $unimedItem = $row['unidadedeMedida'];
                    $quantidadeItem = $row['quantidade'];                    
                }
            }
            
            $query = "SELECT unidadeMedida, quantidade FROM receita_item WHERE idItem = '$idItem' and idReceita = '$idReceita'";

            $resultado = mysqli_query($conexao, $query);
            
            $unimedRec = null;
            $quantidadeRec = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $unimedRec = $row['unidadedeMedida'];
                    $quantidadeRec = $row['quantidade'];  
                }
            }
            
            if ($unimedItem != $unimedRec){
                $quantidadeRec = Receita_Item::converterMedidas($unimedItem, $unimedRec, $quantidadeRec);
            }
            
            mysqli_close($conexao);
            
            $verifica = ($quantidadeItem >= $quantidadeRec);

            return $verifica;
        }
    }
?>

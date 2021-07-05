<?php
    class Receita_Item{
        private $idReceita;
        private $idItem;
        private $quantidade;
        private $unidadeMedida;
        

        function __construct($idReceita, $idItem, $quantidade, $unidadeMedida)
        {
            $this->idReceita = $idReceita;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
            $this->unidadeMedida = $unidadeMedida;
        }

        public static function selectReceita_Itens($idReceita){
            include '../includes/conecta_bd.inc';

            $query = "SELECT idItem, quantidade, unidadeMedida FROM receita_item WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);
            $idItem = null;
            $quantidade = null;
            $unidadeMedida = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $idItem[$i] = $row['idItem'];
                    $quantidade[$i] = $row['quantidade'];
                    $unidadeMedida[$i] = $row['unidadeMedida'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array ($idItem, $quantidade, $unidadeMedida);
        }

        public function cadastrarReceita_Item(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO receita_item (idReceita, idItem, quantidade, unidadeMedida) VALUES ('$this->idReceita', '$this->idItem', '$this->quantidade', $this->unidadeMedida)";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
    }
?>

<?php
    class Receita{
        private $idReceita;
        private $idItem;
        private $quantidade;
        

        function __construct($idReceita, $idItem, $quantidade)
        {
            $this->idReceita = $idReceita;
            $this->idItem = $idItem;
            $this->quantidade = $quantidade;
        }

        public static function selectReceita_Itens(){
            include '../includes/conecta_bd.inc';

            $query = "SELECT idItem, quantidade FROM receita_item WHERE idReceita = '$idReceita' ";

            $resultado = mysqli_query($conexao, $query);
            $idItem = null;
            $quantidade = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $idItem[$i] = $row['idItem'];
                    $quantidade[$i] = $row['quantidade'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $nomeReceita;
        }

        public function cadastrarReceita_Item(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO receita_item (idReceita, idItem, quantidade) VALUES ('$this->idReceita', '$this->idItem', '$this->quantidade')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
?>
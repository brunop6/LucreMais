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

        public static function selectId($descricaoCategoria){
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
?>
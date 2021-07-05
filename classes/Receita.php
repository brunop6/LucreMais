<?php
    class Receita{
        private $nomeReceita;
        private $idUsuario;

        function __construct($idUsuario, $nomeReceita)
        {
            $this->idUsuario = $idUsuario;
            $this->nomeReceita = $nomeReceita;
        }

        public static function selectReceitas($email){
            include '../includes/conecta_bd.inc';

            $query = "SELECT r.nomeReceita 
            FROM receita r, usuario u
            WHERE u.id = r.idUsuario
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            $nomeReceita = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeReceita[$i] = $row['nome'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $nomeReceita;
        }

        public static function selectId($nomeReceita, $email){
            include '../includes/conecta_bd.inc';

            $query = "SELECT r.id 
            FROM receita r 
            WHERE r.nomeReceita = '$nomeReceita'
                AND u.id = r.idUsuario
                AND u.email = '$email'";

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

            $query = "INSERT INTO receita (idUsuario, nome) VALUES ($this->idUsuario, '$this->nomeReceita')";

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

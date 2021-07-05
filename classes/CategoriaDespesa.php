<?php
    class CategoriaDespesa{
        private $idUsuario;
        private $descricao;

        function __construct($idUsuario, $descricao)
        {
            $this->idUsuario = $idUsuario;
            $this->descricao = mb_strtoupper($descricao, mb_internal_encoding());
        }

        public function cadastrarCategoriaDespesa(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO categoriadespesa (descricao, idUsuario) VALUES ('$this->descricao', '$this->idUsuario')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoriadespesa 
            SET idUsuario = '$this->idUsuario', descricao = '$this->descricao' 
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function selectId($descricao){
            include '../includes/conecta_bd.inc';

            $descricao = mb_strtoupper($descricao, mb_internal_encoding());

            $query = "SELECT id FROM categoriadespesa WHERE descricao = '$descricao'";

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

        public static function buscarCategoria($busca){
            include __DIR__.'/../includes/conecta_bd.inc';
            $query = "SELECT descricao FROM categoriadespesa WHERE descricao LIKE '%$busca'";

            $resultado = mysqli_query($conexao, $query);
            $descricao = null;
            if(mysql_num_rows($resultado)>0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $descricao[$i] = $row['descricao'];
                    $i++;
                }
                mysqli_close($conexao);
                return $descricao;
            }
        }


        public static function selectCategoria($id){
            include __DIR__.'/../includes/conecta_bd.inc';

            $query = "SELECT descricao
            FROM categoriadespesa
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);
            $descricao = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $descricao = $row['descricao'];
                }
            }
            mysqli_close($conexao);

            return $descricao;
        }

        public static function selectCategorias(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT cd.id, cd.descricao, DATE_FORMAT(cd.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(cd.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoriadespesa cd, usuario u
            WHERE cd.idUsuario = u.id";

            $resultado = mysqli_query($conexao, $query);
            $descricaoCategoria = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $descricao[$i] = $row['descricao'];
                    $dataCadastro[$i] = $row['dataCadastro'];
                    $dataAtualizacao[$i] = $row['dataAtualizacao'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($id, $descricao, $dataCadastro, $dataAtualizacao, $nomeUsuario);
        }

    }
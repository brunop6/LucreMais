<?php
    class Categoria{
        private $idUsuario;
        private $descricaoCategoria;

        function __construct($idUsuario, $descricaoCategoria)
        {
            $this->idUsuario = $idUsuario;
            $this->descricaoCategoria = mb_strtoupper($descricaoCategoria, mb_internal_encoding());
        }

        /**
         * retorno do tipo matriz de strings
         */
        public static function selectCategorias($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT c.id, c.descricaoCategoria, DATE_FORMAT(c.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(c.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoria c, usuario u
            WHERE c.idUsuario = u.id
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            $id = null;
            $descricaoCategoria = null;
            $dataCadastro = null;
            $dataAtualizacao = null;
            $nomeUsuario = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $descricaoCategoria[$i] = $row['descricaoCategoria'];
                    $dataCadastro[$i] = $row['dataCadastro'];
                    $dataAtualizacao[$i] = $row['dataAtualizacao'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($id, $descricaoCategoria, $dataCadastro, $dataAtualizacao, $nomeUsuario);
        }

        public static function selectCategoria($id){
            include __DIR__.'/../includes/conecta_bd.inc';

            $query = "SELECT descricaoCategoria
            FROM categoria
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);
            $descricaoCategoria = null;
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $descricaoCategoria = $row['descricaoCategoria'];
                }
            }
            mysqli_close($conexao);

            return $descricaoCategoria;
        }

        public static function buscarCategoria($busca, $email){
            include __DIR__.'./../includes/conecta_bd.inc';
            $query = "SELECT c.descricaoCategoria 
            FROM categoria c, usuario u
            WHERE c.descricaoCategoria LIKE '%$busca%'
                AND u.id = c.idUsuario
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            $descricaoCategoria = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $descricaoCategoria[$i] = $row['descricaoCategoria'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $descricaoCategoria;
        }

        public static function selectId($descricaoCategoria, $email){
            include '../includes/conecta_bd.inc';

            $descricaoCategoria = mb_strtoupper($descricaoCategoria, mb_internal_encoding());

            $query = "SELECT c.id 
            FROM categoria c, usuario u
            WHERE c.descricaoCategoria = '$descricaoCategoria'
                AND u.id = c.idUsuario
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

        public function cadastrarCategoria(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO categoria (idUsuario, descricaoCategoria) VALUES ('$this->idUsuario', '$this->descricaoCategoria')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoria SET idUsuario = $this->idUsuario, descricaoCategoria = '$this->descricaoCategoria' WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
    }
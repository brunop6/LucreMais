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
        public static function selectCategorias(){
            include '../includes/conecta_bd.inc';

            $query = "SELECT descricaoCategoria FROM categoria";

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

        public static function selectCategoria($busca){
            include '../includes/conecta_bd.inc';
            $query = "SELECT descricaoCategoria FROM categoria WHERE descricaoCategoria LIKE '%$busca%'";

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

        public static function selectId($descricaoCategoria){
            include '../includes/conecta_bd.inc';

            $query = "SELECT id FROM categoria WHERE descricaoCategoria = '$descricaoCategoria'";

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
    }
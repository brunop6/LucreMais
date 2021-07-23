<?php
    class CategoriaEntrada{
        private $descricao;

        function __construct($descricao)
        {
            $this->descricao = mb_strtoupper($descricao, mb_internal_encoding());
        }

        public function cadastrarCategoriaEntrada(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO categoriaentrada (descricao) VALUES ('$this->descricao')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoriaentrada 
            SET descricao = '$this->descricao' 
            WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function selectId($descricao){
            include __DIR__.'./../includes/conecta_bd.inc';

            $descricao = mb_strtoupper($descricao, mb_internal_encoding());

            $query = "SELECT id FROM categoriaentrada WHERE descricao = '$descricao'";

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

        public static function buscarCategoria($busca, $email){
            include __DIR__.'./../includes/conecta_bd.inc';
            $query = "SELECT ce.descricao 
            FROM categoriaentrada ce, entrada e, usuario u 
            WHERE descricao LIKE '%$busca%'
                AND ce.id = e.idCategoriaEntrada
                AND e.idUsuario = u.id
                AND u.email = '$email'";

            $resultado = mysqli_query($conexao, $query);
            $descricao = null;
            if(mysqli_num_rows($resultado)>0){
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
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT descricao
            FROM categoriaentrada
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

        public static function selectCategorias($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT DISTINCT ce.id, ce.descricao, DATE_FORMAT(ce.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(ce.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoriaentrada ce, entrada e, usuario u
            WHERE e.idUsuario = u.id
                AND e.idCategoriaEntrada = ce.id
                AND u.email = '$email'
            ORDER BY ce.id";

            $resultado = mysqli_query($conexao, $query);

            $id = null;
            $descricao = null;
            $dataCadastro = null;
            $dataAtualizacao = null;
            $nomeUsuario = null;
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
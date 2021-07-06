<?php
    class CategoriaRecibo{
        private $descricao;

        function __construct($descricao)
        {
            $this->descricao = mb_strtoupper($descricao, mb_internal_encoding());
        }

        public function cadastrarCategoriaRecibo(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO categoriarecibo (descricao) VALUES ('$this->descricao')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoriarecibo 
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

            $query = "SELECT id FROM categoriarecibo WHERE descricao = '$descricao'";

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
            $query = "SELECT cr.descricao 
            FROM categoriarecibo cr, recibo r, usuario u 
            WHERE descricao LIKE '%$busca%'
                AND cr.id = r.idCategoriaRecibo
                AND r.idUsuario = u.id
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
            FROM categoriarecibo
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

            $query = "SELECT cr.id, cr.descricao, DATE_FORMAT(cr.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(cr.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoriarecibo cr, recibo r, usuario u
            WHERE r.idUsuario = u.id
                AND r.idCategoriaRecibo = cr.id
                AND u.email = '$email'";

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
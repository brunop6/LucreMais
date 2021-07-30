<?php
    class CategoriaReceitaFinanceiro{
        private $idUsuario;
        private $descricao;

        function __construct($descricao, $idUsuario)
        {
            $this->descricao = mb_strtoupper($descricao, mb_internal_encoding());
            $this->idUsuario = $idUsuario;
        }

        public function cadastrarCategoriaReceita(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO categoriareceitafinanceiro (idUsuario, descricao) VALUES ($this->idUsuario, '$this->descricao')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoriareceitafinanceiro 
            SET idUsuario = $this->idUsuario, descricao = '$this->descricao' 
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

            $query = "SELECT id FROM categoriareceitafinanceiro WHERE descricao = '$descricao'";

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
            
            $query = "SELECT c.descricao 
            FROM categoriareceitafinanceiro c, receitafinanceiro r, usuario u 
            WHERE descricao LIKE '%$busca%'
                AND c.id = r.idCategoriareceitafinanceiro
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
            FROM categoriareceitafinanceiro
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

            $query = "SELECT DISTINCT c.id, c.descricao, DATE_FORMAT(c.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(c.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoriareceitafinanceiro c, receitafinanceiro r, usuario u
            WHERE r.idUsuario = u.id
                AND r.idCategoriareceitaFinanceiro = c.id
                AND u.email = '$email'
            ORDER BY c.id";

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
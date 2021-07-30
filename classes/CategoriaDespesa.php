<?php
    class CategoriaDespesa{
        private $idUsuario;
        private $descricao;

        function __construct($descricao, $idUsuario)
        {
            $this->descricao = mb_strtoupper($descricao, mb_internal_encoding());
            $this->idUsuario = $idUsuario;
        }

        public function cadastrarCategoriaDespesa(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO categoriadespesa (idUsuario, descricao) VALUES ($this->idUsuario, '$this->descricao')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarCategoria($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE categoriadespesa 
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

        public static function buscarCategoria($busca, $email){
            include __DIR__.'./../includes/conecta_bd.inc';
            $query = "SELECT cd.descricao 
            FROM categoriadespesa cd, despesa d, usuario u 
            WHERE cd.descricao LIKE '%$busca%'
                AND cd.id = d.idCategoriaDespesa
                AND d.idUsuario = u.id
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

        public static function selectCategorias($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT DISTINCT cd.id, cd.descricao, DATE_FORMAT(cd.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(cd.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario  
            FROM categoriadespesa cd, despesa d, usuario u
            WHERE d.idUsuario = u.id
                AND d.idCategoriaDespesa = cd.id
                AND u.email = '$email'
            ORDER BY cd.id";

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
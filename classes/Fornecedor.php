<?php
    class Fornecedor{
        private $idUsuario;
        private $nome;
        private $email;
        private $telefone;
        private $cnpj;
        private $endereco;

        function __construct($idUsuario, $nome, $email, $telefone, $cnpj, $endereco)
        {
            $this->idUsuario = $idUsuario;
            $this->nome = mb_strtoupper($nome, mb_internal_encoding());
            $this->email = mb_strtolower($email, mb_internal_encoding());
            $this->telefone = $telefone;
            $this->cnpj = $cnpj;
            $this->endereco = $endereco;

            if(strlen($this->email) < 10){
                $this->email = NULL;
            }
            if(strlen($this->endereco) < 10){
                $this->endereco = NULL;
            }
        }
        
        /**
         * retorno do tipo matriz de strings
         */
        public static function selectFornecedores(){
            include '../includes/conecta_bd.inc';

            $query = "SELECT f.id, f.nomeFornecedor, f.email, f.telefone, f.cnpj, f.endereco, DATE_FORMAT(f.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro, DATE_FORMAT(f.dataAtualizacao, '%d/%m/%Y %H:%i') AS dataAtualizacao, u.nomeUsuario 
            FROM fornecedor f, usuario u
            WHERE f.idUsuario = u.id
            ORDER BY f.nomeFornecedor, f.endereco, f.id";

            $resultado = mysqli_query($conexao, $query);
            $nomeFornecedor = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $nomeFornecedor[$i] = $row['nomeFornecedor'];
                    $email[$i] = $row['email'];
                    $telefone[$i] = $row['telefone'];
                    $cnpj[$i] = $row['cnpj'];
                    $endereco[$i] = $row['endereco'];
                    $dataCadastro[$i] = $row['dataCadastro'];
                    $dataAtualizacao[$i] = $row['dataAtualizacao'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($id, $nomeFornecedor, $email, $telefone, $cnpj, $endereco, $dataCadastro, $dataAtualizacao, $nomeUsuario);
        }

        public static function buscarFornecedor($busca){
            include '../includes/conecta_bd.inc';

            $query = "SELECT nomeFornecedor FROM fornecedor WHERE nomeFornecedor LIKE '%$busca%'";

            $resultado = mysqli_query($conexao, $query);
            $nomeFornecedor = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $nomeFornecedor[$i] = $row['nomeFornecedor'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return $nomeFornecedor;
        }
        public static function selectId($nomeFornecedor){
            include '../includes/conecta_bd.inc';

            $query = "SELECT id FROM fornecedor WHERE nomeFornecedor = '$nomeFornecedor'";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $id = $row['id'];
                }
            }

            mysqli_close($conexao);

            return $id;
        }

        public static function selectFornecedor($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT nomeFornecedor, email, telefone, cnpj, endereco FROM fornecedor WHERE id = $id";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $nomeFornecedor = $row['nomeFornecedor'];
                    $email = $row['email'];
                    $telefone = $row['telefone'];
                    $cnpj = $row['cnpj'];
                    $endereco = $row['endereco'];
                }
            }
            mysqli_close($conexao);

            return array($nomeFornecedor, $email, $telefone, $cnpj, $endereco);
        }

        public function cadastrarFornecedor(){
            include '../includes/conecta_bd.inc';
            $query = "INSERT INTO fornecedor (idUsuario, nomeFornecedor, email, telefone, cnpj, endereco) VALUES ('$this->idUsuario', '$this->nome', '$this->email', '$this->telefone', '$this->cnpj', '$this->endereco')";
            
            //Formato CNPJ XX. XXX. XXX/0001-XX
            if(strlen($this->cnpj) < 14){
                $query = "INSERT INTO fornecedor (idUsuario, nomeFornecedor, email, telefone, endereco) VALUES ('$this->idUsuario', '$this->nome', '$this->email', '$this->telefone', '$this->endereco')";
            }

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editarFornecedor($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE fornecedor 
            SET idUsuario = $this->idUsuario, nomeFornecedor = '$this->nome', email = '$this->email', telefone = '$this->telefone', cnpj = '$this->cnpj', endereco = '$this->endereco' 
            WHERE id = $id";

            if(strlen($this->cnpj) < 14){
                $query = "UPDATE fornecedor 
                SET idUsuario = $this->idUsuario, nomeFornecedor = '$this->nome', email = '$this->email', telefone = '$this->telefone', cnpj = NULL, endereco = '$this->endereco' 
                 WHERE id = $id";
            }
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
    }
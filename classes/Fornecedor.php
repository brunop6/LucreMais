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
            $this->nome = $nome;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->cnpj = $cnpj;
            $this->endereco = $endereco;
        }
        
        /**
         * retorno do tipo matriz de strings
         */
        public static function selectFornecedores(){
            include '../includes/conecta_bd.inc';

            $query = "SELECT nomeFornecedor FROM fornecedor";

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

        public function cadastrarFornecedor(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO fornecedor (idUsuario, nomeFornecedor, email, telefone, cnpj, endereco) VALUES ('$this->idUsuario', '$this->nome', '$this->email', '$this->telefone', '$this->cnpj', '$this->endereco')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }
    }
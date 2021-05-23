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
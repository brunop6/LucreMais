<?php
    include_once __DIR__.'./../includes/encrypt.inc';
         
    class Usuario{
        private $nomeUsuario;
        private $email;
        private $senha;

        function __construct($nomeUsuario, $email, $senha){
            $senha = encryptPassword($nomeUsuario, $email, $senha);

            $this->nomeUsuario = $nomeUsuario;
            $this->email = $email; 
            $this->senha = $senha;
        }

        public static function selectId($nomeUsuario){
            include __DIR__.'./../includes/conecta_bd.inc';
            
            $query = "SELECT id FROM usuario WHERE nomeUsuario = '$nomeUsuario'";

            $resultado = mysqli_query($conexao, $query);
            
            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $id = $row['id'];
                }
            }

            mysqli_close($conexao);
            
            return $id;
        }
        
        public function cadastrarUsuario(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO usuario (nomeUsuario, email, senha) VALUES ('$this->nomeUsuario', '$this->email', '$this->senha')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editarConta($nomeUsuario, $senha){
            include '../includes/conecta_bd.inc';

            $id = Usuario::selectId($this->nomeUsuario);
            $senha = encryptPassword($nomeUsuario, $this->email, $senha);

            $query = "UPDATE usuario SET nomeUsuario = '$nomeUsuario', senha = '$senha' WHERE id = $id";

            $resultado = mysqli_query($conexao,$query);

            if($resultado){
                return 'Edição realizada com sucesso!';
            }
            return mysqli_error($conexao);
        }
    }

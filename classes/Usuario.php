<?php
    include_once __DIR__.'./../includes/encrypt.inc';
         
    class Usuario{
        private $idNivel;
        private $nomeUsuario;
        private $email;
        private $senha;

        function __construct($idNivel, $nomeUsuario, $email, $senha){
            $senha = encryptPassword($nomeUsuario, $email, $senha);

            $this->idNivel = $idNivel; 
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

        public static function selectNivel($idUsuario){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT n.descricao
            FROM nivelusuario n, usuario u
            WHERE n.id = u.idNivelUsuario
                AND u.id = $idUsuario";

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

        public static function selectIdNivel($descricao){
            include __DIR__.'./../includes/conecta_bd.inc';

            $descricao = mb_strtoupper($descricao, mb_internal_encoding());
            $query = "SELECT id FROM nivelusuario WHERE descricao = '$descricao'";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $idNivel = $row['id'];
                }
            }
            mysqli_close($conexao);

            return $idNivel;
        } 

        public static function selectPermissoes($idUsuario){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT m.descricao, a.inserir, a.editar, a.excluir, a.consultar
            FROM menu m, usuario u, nivelusuario n, permissao p, acao a
            WHERE u.idNivelUsuario = n.id
                AND p.idNivelUsuario = n.id
                AND p.idMenu = m.id
                AND a.idPermissao = p.id
                AND u.id = $idUsuario";

            $resultado = mysqli_query($conexao, $query);

            $menu = null;
            $inserir = null;
            $editar = null;
            $excluir = null;
            $consultar = null;

            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $menu[$i] = $row['descricao'];
                    $inserir[$i] = $row['inserir'];
                    $editar[$i] = $row['editar'];
                    $excluir[$i] = $row['excluir'];
                    $consultar[$i] = $row['consultar'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($menu, $inserir, $editar, $excluir, $consultar);
        }

        public function cadastrarUsuario(){
            include '../includes/conecta_bd.inc';

            $query = "INSERT INTO usuario (idNivelUsuario, nomeUsuario, email, senha) VALUES ($this->idNivel, '$this->nomeUsuario', '$this->email', '$this->senha')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editarConta($id){
            include '../includes/conecta_bd.inc';

            $query = "UPDATE usuario SET idNivelUsuario = $this->nivelUsuario, nomeUsuario = '$this->nomeUsuario', email = '$this->email' senha = '$this->senha' WHERE id = $id";

            $resultado = mysqli_query($conexao,$query);

            if($resultado){
                return 'Edição realizada com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public static function verificarMenu($idUsuario, $menu){
            list($menus, $inserir, $editar, $excluir, $consultar) = Usuario::selectPermissoes($idUsuario);

            $permissão = false;

            foreach($menus as $value){
                if(strpos($value, $menu) !== false){
                    $permissão = true;
                    break;
                }
            }
            return $permissão;
        }
    }

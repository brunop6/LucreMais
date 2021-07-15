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

        public static function selectEmail($idUsuario){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT email FROM usuario WHERE id = $idUsuario";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
                    $email = $row['email'];
                }
            }
            mysqli_close($conexao);
            return $email;
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

        public static function selectAcoes($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT a.id, m.descricao AS menu, a.inserir, a.editar, a.excluir, a.consultar
            FROM nivelusuario n, usuario u, permissao p, acao a, menu m
            WHERE u.idNivelUsuario = n.id
                AND p.idNivelUsuario = n.id
                AND a.idPermissao = p.id
                AND p.idMenu = m.id
                AND n.id <> 1
                AND u.email = '$email'";
            $resultado = mysqli_query($conexao, $query);

            $id = null;
            $menu = null;
            $inserir = null;
            $editar = null;
            $excluir = null;
            $consultar = null;

            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $menu[$i] = $row['menu'];
                    $inserir[$i] = $row['inserir'];
                    $editar[$i] = $row['editar'];
                    $excluir[$i] = $row['excluir'];
                    $consultar[$i] = $row['consultar'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($id, $menu, $inserir, $editar, $excluir, $consultar);
        }

        public static function selectNiveisAcesso($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT n.descricao
            FROM nivelusuario n, usuario u
            WHERE u.idNivelUsuario = n.id
                AND u.email = '$email'";
            $resultado = mysqli_query($conexao, $query);

            $descricao = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $descricao[$i] = $row['descricao'];
                }
            }
            mysqli_close($conexao);

            return $descricao;
        }

        public function cadastrarUsuario(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO usuario (idNivelUsuario, nomeUsuario, email, senha) VALUES ($this->idNivel, '$this->nomeUsuario', '$this->email', '$this->senha')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return 'Cadastro realizado com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public function editarConta($id){
            include __DIR__.'./../includes/conecta_bd.inc';

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

        public static function selectMenusDisponiveis($nivelAcesso, $email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT DISTINCT m.id, m.descricao
            FROM menu m, nivelusuario n, permissao p, usuario u
            WHERE u.idNivelUsuario = n.id
                AND p.idNivelUsuario = n.id
                AND p.idMenu = m.id
                AND u.email = '$email'
                AND m.id NOT IN (
                    SELECT m.id 
                    FROM menu m, nivelusuario n, permissao p, usuario u
                    WHERE u.idNivelUsuario = n.id
                        AND p.idNivelUsuario = n.id
                        AND p.idMenu = m.id
                        AND u.email = '$email'
                        AND n.descricao = '$nivelAcesso'
                )";
            $resultado = mysqli_query($conexao, $query);

            $idMenu = null;
            $descricaoMenu = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $idMenu[$i] = $row['id'];
                    $descricaoMenu[$i] = $row['descricao'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($idMenu, $descricaoMenu);
        }

        public static function editarAcao($idAcao, $inserir, $editar, $excluir, $consultar){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE acao 
            SET inserir = '$inserir', editar = '$editar', excluir = '$excluir', consultar = '$consultar'
            WHERE id = $idAcao";

            $resultado = mysqli_query($conexao,$query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao).' - Id='.$idAcao;
        }

        public static function cadastrarPermissao($idNivelUsuario, $idMenu){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO permissao (idNivelUsuario, idMenu) VALUES ($idNivelUsuario, $idMenu)";

            $resultado = mysqli_query($conexao,$query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }
    }

<?php
    include_once __DIR__.'./../includes/encrypt.inc';
         
    class Usuario{
        private $admin;
        private $nomeUsuario;
        private $email;
        private $senha;

        function __construct($admin, $nomeUsuario, $email, $senha){
            $senha = encryptPassword($nomeUsuario, $email, $senha);

            $this->admin = $admin; 
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
            FROM nivel n, usuario u, nivelusuario nu
            WHERE nu.idUsuario = u.id
                AND nu.idNivel = n.id
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

        public static function selectIdNivel($descricao, $email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $descricao = mb_strtoupper($descricao, mb_internal_encoding());

            $query = "SELECT n.id 
            FROM nivel n, usuario u 
            WHERE n.idUsuario = u.id
                AND u.email = '$email'
                AND n.descricao = '$descricao'";

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

            $query = "SELECT m.descricao, p.inserir, p.editar, p.excluir
            FROM menu m, permissao p, usuario u, nivel n, nivelusuario nu
            WHERE p.idMenu = m.id
                AND p.idNivel = n.id
                AND nu.idNivel = n.id
                AND nu.idUsuario = u.id
                AND u.id = $idUsuario";

            $resultado = mysqli_query($conexao, $query);

            $menu = null;
            $inserir = null;
            $editar = null;
            $excluir = null;

            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $menu[$i] = $row['descricao'];
                    $inserir[$i] = $row['inserir'];
                    $editar[$i] = $row['editar'];
                    $excluir[$i] = $row['excluir'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($menu, $inserir, $editar, $excluir);
        }

        public static function selectNiveisAcesso($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT DISTINCT n.id, n.descricao
            FROM nivel n, usuario u
            WHERE n.idUsuario = u.id
                AND u.email = '$email'";
            $resultado = mysqli_query($conexao, $query);

            $id = null;
            $descricao = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $id[$i] = $row['id'];
                    $descricao[$i] = $row['descricao'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($id, $descricao);
        }

        public function cadastrarUsuario(){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO usuario (admin, nomeUsuario, email, senha) VALUES ('$this->admin', '$this->nomeUsuario', '$this->email', '$this->senha')";
        
            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public function editarConta($id){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE usuario SET admin = '$this->admin', nomeUsuario = '$this->nomeUsuario', email = '$this->email' senha = '$this->senha' WHERE id = $id";

            $resultado = mysqli_query($conexao,$query);

            if($resultado){
                return 'Edição realizada com sucesso!';
            }
            return mysqli_error($conexao);
        }

        public static function verificarMenu($idUsuario, $menu){
            //Administradores possuem acesso liberado
            if(Usuario::admin($idUsuario)){
                return true;
            }

            list($menus, $inserir, $editar, $excluir) = Usuario::selectPermissoes($idUsuario);

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

        public static function selectContasVinculadas($idUsuario, $email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT u.id as idUsuario, u.nomeUsuario, n.id as idNivelAcesso, n.descricao
            FROM usuario u, nivelusuario nu, nivel n
            WHERE nu.idUsuario = u.id
                AND nu.idNivel = n.id
                AND u.id <> $idUsuario
                AND u.email = '$email'";
            
            $resultado = mysqli_query($conexao, $query);

            $idUsuario = null;
            $nomeUsuario = null;
            $idNivelAcesso = null;
            $nivelAcesso = null;
            if(mysqli_num_rows($resultado) > 0){
                $i = 0;
                while($row = mysqli_fetch_array($resultado)){
                    $idUsuario[$i] = $row['idUsuario'];
                    $nomeUsuario[$i] = $row['nomeUsuario'];
                    $idNivelAcesso[$i] = $row['idNivelAcesso'];
                    $nivelAcesso[$i] = $row['descricao'];
                    $i++;
                }
            }
            mysqli_close($conexao);

            return array($idUsuario, $nomeUsuario, $idNivelAcesso, $nivelAcesso);
        }

        public static function editarNivelAcesso($idUsuario, $idNivel){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "UPDATE usuario 
            SET idNivelUsuario = $idNivel
            WHERE id = $idUsuario";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao).' - id: '.$idUsuario;
        }
        
        public static function cadastrarNivel($idUsuario, $descricaoNivel){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO nivel(idUsuario, descricao) 
            VALUES ($idUsuario, '$descricaoNivel')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "INSERT INTO permissao (idNivel, idMenu, inserir, editar, excluir)
            VALUES ($idNivel, $idMenu, '$inserir', '$editar', '$excluir')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        public static function cadastrarNivelUsuario($idUsuario, $idNivel){
            include __DIR__.'./../includes/conecta_bd.inc';
            
            $query = "INSERT INTO nivelusuario (idUsuario, idNivel) 
            VALUES ('$idUsuario', '$idNivel')";

            $resultado = mysqli_query($conexao, $query);

            if($resultado){
                return true;
            }
            return mysqli_error($conexao);
        }

        /**
         * Somente uma pessoa por e-mail poderá cadastrar um usuário de maneira não autenticada;
         * 
         * @return false -> e-mail indisponível (já possui um Administrador).
         * @return true  -> e-mail disponível.
         */
        public static function verificarEmail($email){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT id FROM usuario WHERE email = '$email'";

            $resultado = mysqli_query($conexao, $query);

            if(mysqli_num_rows($resultado) > 0){
                return false;
            }
            return true;
        }

        /**
         * @return true -> usuário com permissão de administrador
         * @return false -> usuário sem permissão de administrador
         * @return null -> id usuário inválido
         */
        public static function admin($idUsuario){
            include __DIR__.'./../includes/conecta_bd.inc';

            $query = "SELECT admin FROM usuario WHERE id = $idUsuario";

            $resultado = mysqli_query($conexao, $query);
            
            $admin = null;
            if(mysqli_num_rows($resultado) > 0 ){
                while($row = mysqli_fetch_array($resultado)){
                    $admin = $row['admin'];
                }
            }
            switch ($admin) {
                case '1':
                    return true;
                    break;
                case '0':
                    return false;
                    break;
            }
            return null;
        }
        
        public function editarContaUsusario($id){
          include '../includes/conecta_bd.inc';
            
          $data = date('d/m/Y');

          $query = "UPDATE usuario 
          SET idNivelUsuario = $this->idNivel, nomeUsuario = $this->nomeUsuario, email = $this->email,senha = $this->senha, dataAtualizacao = '$data'
          WHERE id = $id";

          $resultado = mysqli_query($conexao, $query);

          if($resultado){
            return true;
          } 
          return mysqli_error($conexao);
        }
    }

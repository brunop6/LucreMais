<?php
    if(!isset($_POST['descricao'])){
        header('Location: ./../permissoes.php');
        die();
    }else{
        include_once './../../../classes/Usuario.php';

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'];
        $emailUsuario = $_SESSION['email_usuario'];
        $descricao = $_POST['descricao'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="./../../../public/img/icone-LucreMais.png">
    <link rel="stylesheet" href="./aparencia_CN.css">

    <title>Cadastrar Novo Nível</title>
</head>
<body>
    <?php
        $resultado = Usuario::cadastrarNivel($idUsuario, $descricao);

        if(!$resultado){
            echo "<h3>Erro ao cadastrar nível de acesso: </h3>";
            echo "<p>$resultado</p>";
            echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
            die();
        }

        $idNivel = Usuario::selectIdNivel($descricao, $emailUsuario);

        if(isset($_POST['estoque'])){
            $idMenu = 1;

            if(isset($_POST['estoque-inserir'])){
                $inserir = 1;
            }else{
                $inserir = 0;
            }

            if(isset($_POST['estoque-editar'])){
                $editar = 1;
            }else{
                $editar = 0;
            }

            if(isset($_POST['estoque-excluir'])){
                $excluir = 1;
            }else{
                $excluir = 0;
            }
            $resultado = Usuario::cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir);

            if(!$resultado){
                echo "<h3>Erro ao cadastrar permissão do menu Estoque: </h3>";
                echo "<p>$resultado</p>";
                echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
                die();
            }
        }

        if(isset($_POST['fornecedores'])){
            $idMenu = 2;

            if(isset($_POST['fornecedores-inserir'])){
                $inserir = 1;
            }else{
                $inserir = 0;
            }

            if(isset($_POST['fornecedores-editar'])){
                $editar = 1;
            }else{
                $editar = 0;
            }

            if(isset($_POST['fornecedores-excluir'])){
                $excluir = 1;
            }else{
                $excluir = 0;
            }
            $resultado = Usuario::cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir);

            if(!$resultado){
                echo "<h3>Erro ao cadastrar permissão do menu Fornecedores: </h3>";
                echo "<p>$resultado</p>";
                echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
                die();
            }
        }

        if(isset($_POST['itens'])){
            $idMenu = 3;

            if(isset($_POST['itens-inserir'])){
                $inserir = 1;
            }else{
                $inserir = 0;
            }

            if(isset($_POST['itens-editar'])){
                $editar = 1;
            }else{
                $editar = 0;
            }

            if(isset($_POST['itens-excluir'])){
                $excluir = 1;
            }else{
                $excluir = 0;
            }
            $resultado = Usuario::cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir);

            if(!$resultado){
                echo "<h3>Erro ao cadastrar permissão do menu Itens: </h3>";
                echo "<p>$resultado</p>";
                echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
                die();
            }
        }

        if(isset($_POST['receitas'])){
            $idMenu = 4;

            if(isset($_POST['receitas-inserir'])){
                $inserir = 1;
            }else{
                $inserir = 0;
            }

            if(isset($_POST['receitas-editar'])){
                $editar = 1;
            }else{
                $editar = 0;
            }

            if(isset($_POST['receitas-excluir'])){
                $excluir = 1;
            }else{
                $excluir = 0;
            }
            $resultado = Usuario::cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir);

            if(!$resultado){
                echo "<h3>Erro ao cadastrar permissão do menu Receitas: </h3>";
                echo "<p>$resultado</p>";
                echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
                die();
            }
        }

        if(isset($_POST['financeiro'])){
            $idMenu = 5;

            if(isset($_POST['financeiro-inserir'])){
                $inserir = 1;
            }else{
                $inserir = 0;
            }

            if(isset($_POST['financeiro-editar'])){
                $editar = 1;
            }else{
                $editar = 0;
            }

            if(isset($_POST['financeiro-excluir'])){
                $excluir = 1;
            }else{
                $excluir = 0;
            }
            $resultado = Usuario::cadastrarPermissao($idNivel, $idMenu, $inserir, $editar, $excluir);

            if(!$resultado){
                echo "<h3>Erro ao cadastrar permissão do menu Financeiro: </h3>";
                echo "<p>$resultado</p>";
                echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
                die();
            }
        }

        echo "<h3>Nível de acesso \"$descricao\" cadastrado com sucesso!</h3>";
        echo "<button onclick=\"window.location.href='./../permissoes.php'\">Retornar às permissões</button>";
    ?>
</body>
</html>
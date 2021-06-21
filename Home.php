<?php
    include 'includes/validacao_cookies.inc';
    include_once './classes/Usuario.php';
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $nomeUsuario = $_SESSION['nome_usuario'];

    $idUsuario = Usuario::selectId($nomeUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="Aparencia.css">
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <?php
                    if(Usuario::verificarMenu($idUsuario, "Fornecedores")){
                        echo '<li><a href="./fornecedor/fornecedor.php">Fornecedores</a></li>';
                    }
                    if(Usuario::verificarMenu($idUsuario, "Itens")){
                        echo '<li><a href="./item/item.php">Itens</a></li>';
                    }
                    if(Usuario::verificarMenu($idUsuario, "Estoque")){
                        echo '<li><a href="./estoque/estoque.php">Estoque</a></li>';
                    }
                    if(Usuario::verificarMenu($idUsuario, "Receitas")){
                        echo '<li><a href="./Receitas/cadastrar_receitas.php">Receitas</a></li>';
                    }
                ?>      
                <li><a href="logoff.php">Logoff</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
<?php
    include 'includes/validacao_cookies.inc';
    include_once './classes/Usuario.php';
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $nomeUsuario = $_SESSION['nome_usuario'];

    $idUsuario = Usuario::selectId($nomeUsuario);
    $nivelAcesso = Usuario::selectNivel($idUsuario);
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
            </ul>
        </nav>
    </header>

    <input type="checkbox" id="btn-sidebar">

    <label for="btn-sidebar">
        <b style="user-select: none" id="btn">&#8250;</b>
        <b style="user-select: none" id="cancel">&#8249;</b>
    </label>

    <div class="sidebar">
        <header>
            <h3><?php echo $nomeUsuario; ?></h3>
            <p><?php echo $nivelAcesso; ?></p>
            <br>
        </header>
        <ul>
            <li><a href="#">Conta</a></li>
            <li><a href="#">Permissões</a></li>
            <li><a href="logoff.php">Logoff</a></li>
        </ul>
    </div>

    <section>
        
    </section>
</body>
</html>
<?php
    include './../../includes/validacao_cookies.inc';
    include_once './../../classes/Usuario.php';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $nomeUsuario = $_SESSION['nome_usuario'];
    $nivelUsuario = $_SESSION['nivel_usuario'];
    $emailUsuario = $_SESSION['email_usuario'];

    $niveisAcesso = Usuario::selectNiveisAcesso($emailUsuario);
    list($id, $menu, $inserir, $editar, $excluir, $consultar) = Usuario::selectAcoes($emailUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./permissoes.js"></script>
    <link rel="stylesheet" href="./../../Aparencia.css">
    <link rel="stylesheet" href="./permissoes.css">
    <title>Permissões</title>
</head>
<body>
    <p id="emailUsuario" hidden><?php echo $emailUsuario; ?></p>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="#">Novo nível de acesso</a></li>
                <li><a href="../../Home.php">Voltar</a></li>    
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
            <p><?php echo $nivelUsuario; ?></p>
            <br>
        </header>
        <ul>
            <li><a href="#">Conta</a></li>
            <li><a href="logoff.php">Logoff</a></li>
        </ul>
    </div>
    <section id="main">
        <h3>Administrador:</h3>
        <br>
        <p>Todas as permissões</p>
        <form action="./edita_acoes/editar_acoes.php" method="POST" id="form-permissoes">
            <input type="hidden" name="nivelAtual" id="nivelAtual">
            <?php
                $countNivel = 0;
                //Carregamento dos níveis já cadastrados
                foreach($niveisAcesso as $nivel){
                    echo "<br><hr><br>";
                    echo "<h3 id='nivel$countNivel'>$nivel:</h3>";
                    //Menus e ações permitidas do respectivo nível
                    $i = 0;
                    foreach($menu as $menu){
                        echo "<p><br><b>$menu:</b></p>";
                        
                        echo "<input type='hidden' name='idAcao$i' value='$id[$i]'>";
                        echo "<label for='inserir$i' class='inserir'>Inserir </label>";
                        echo "<input type='checkbox' name='inserir$i' id='inserir$i'";
                        if($inserir[$i]){
                            echo 'checked';
                        }
                        echo '>';
        
                        echo "<label for='editar$i'>Editar </label>";
                        echo "<input type='checkbox' name='editar$i' id='editar$i'";
                        if($editar[$i]){
                            echo 'checked';
                        }
                        echo '>';
        
                        echo "<label for='excluir$i'>Excluir </label>";
                        echo "<input type='checkbox' name='excluir$i' id='excluir$i'";
                        if($excluir[$i]){
                            echo 'checked';
                        }
                        echo '>';
        
                        echo "<label for='consultar$i'>Consultar </label>";
                        echo "<input type='checkbox' name='consultar$i' id='consultar$i'";
                        if($consultar[$i]){
                            echo 'checked';
                        }
                        echo '>';
                        $i++;
                    }
                    if($i < 5){
                        echo "<br><button type='button' id='btn-addMenu' onclick='desbloquearMenu($countNivel)'>Desbloquear menu</button>"; //Chamar função js para criação de elementos do form
                    }
                    $countNivel++;
                }   
            ?>
            <p id='btn-salvar'><input type="submit" value="Salvar"></p>
        </form>
    </section>
</body>
</html>
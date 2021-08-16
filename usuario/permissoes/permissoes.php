<?php

use Sabberworm\CSS\Value\Value;

include './../../includes/validacao_cookies.inc';
include_once './../../classes/Usuario.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$idUsuario = $_SESSION['id_usuario'];
$nomeUsuario = $_SESSION['nome_usuario'];
$nivelUsuario = $_SESSION['nivel_usuario'];
$emailUsuario = $_SESSION['email_usuario'];

if (isset($_GET['status'])) {
    $status = $_GET['status'];
} else {
    $status = 1;
    }

if ($nivelUsuario != "Administrador") {
    header('Location: ./../../Home.php');
    die();
}

//Níveis de acesso disponíveis para o grupo de contas
list($idNiveisConta, $niveisConta) = Usuario::selectNiveisAcesso($emailUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="./permissoes.js"></script>

    <link rel="stylesheet" href="./../../public/css/headerMenu.css">
    <link rel="stylesheet" href="./../../public/css/sidebarMenu.css">
    <link rel="stylesheet" href="./../../public/css/inputs.css">
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
                <li><a href="./cadastro_nivel/cadastro_nivel.php">Novo nível de acesso</a></li>
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
            <li><a href="./../edita_usuario/edita_usuario.php">Conta</a></li>
            <li><a href="./../../logoff.php">Logoff</a></li>
        </ul>
    </div>
    <section id="main">
        <div class="filtros">
                <select id="status" onchange="alterarExibicao()">
                    <?php
                    if ($status == 1) {
                        echo "
                        <option value='1'>Ativos</option>
                        <option value='0'>Inativos</option>
                        ";
                    } else {
                        echo "
                        <option value='0'>Inativos</option>
                        <option value='1'>Ativos</option>
                        ";
                    }
                    ?>
                </select>
        </div>
        <form action="./edita_permissoes/editar_permissoes.php" method="POST">
            <?php
                //Dados das contas vinculadas
                list($admin, $idUsuarios, $nomeUsuarios, $idNiveis, $niveisAcesso, $statusUsuarios) = Usuario::selectContasVinculadas($idUsuario, $emailUsuario, $status);
                if (empty($idUsuarios)) {
                    if($status == 1){
                        echo "<h3>Não há outras contas ativas vinculadas a este e-mail!</h3>";   
                    }else{
                        echo "<h3>Não há outras contas inativas vinculadas a este e-mail!</h3>";
                    }
                } else {
                    echo "<h3>Contas vinculadas:</h3>\n";
                }
            ?>

            <div class="contas">
                <?php                
                    if (!empty($idUsuarios)) {
                        //Formação dos selects
                        $i = 0;
                        foreach ($idUsuarios as $idU) {
                            echo "<input type='hidden' name='usuario$i' value='$idU'>";
                            
                            echo "<fieldset>
                                <legend>$nomeUsuarios[$i]</legend>
                                <b>Administrador:</b>
                            
                                <div class='inputs'>
                                    <label for='admin1-$i'>Sim</label>
                                    <input type='radio' id='admin1-$i' name='admin$i' value='1'
                            ";
                            if ($admin[$i] == '1'){
                                echo ' checked ';
                            }
                            echo ">";

                            echo "<label for='admin0-$i'>Não</label>
                                <input type='radio' id='admin0-$i' name='admin$i' value='0'
                            ";
                            if ($admin[$i] == '0'){
                                echo ' checked ';
                            }
                            echo">
                                </div>
                            ";
                            
                            echo "<br><b>Status: </b>
                                <div class='inputs'>
                            ";
                            echo "<label for='statusAtivo$i'>Ativo</label>";
                            echo "<input type='radio' name='statusUsuario$i' id='statusAtivo$i' value='1'";
                            if($statusUsuarios[$i] == '1'){
                                echo 'checked';
                            }
                            echo '>';
                            echo "<label for='statusInativo$i'>Inativo</label>";
                            echo "<input type='radio' name='statusUsuario$i' id='statusInativo$i' value='0' ";
                            if($statusUsuarios[$i] == '0'){
                                echo 'checked';
                            }
                            echo '>
                                </div>
                            ';

                            //Select de níveis de acesso somente para usuários padrão
                            if($admin[$i] == '0'){
                                echo "<br><b>Nível de acesso: </b>
                                    <br>
                                    <select name='nivelUsuario$i'>
                                ";
                                //Formação das options
                                $j = 0;
                                foreach ($idNiveisConta as $idNivelConta) {
                                    echo "<option value='$idNivelConta'";
                                    if ($idNivelConta == $idNiveis[$i]) {
                                        echo 'selected';
                                    }
                                    echo ">$niveisConta[$j]</option>\n";
                                    $j++;
                                }
                                echo "</select>\n";
                            }

                            echo '</fieldset>';

                            $i++;
                        }
                        //Controle do número de usuários para edição
                        echo "<input type='hidden' name='numUsuarios' value='$i'>";
                    }
                ?>
            </div>
            
            <?php
                if(!empty($idUsuarios)){
                    echo "<p><input type='submit' value='Salvar'></p>";
                    echo "<p><input type='button' value='Cadastrar funcionário' onclick='window.location.href=\"./../cadastro_funcionario/cadastro_funcionario.php\"'></p>";
                }
            ?>
        </form>
    </section>
</body>
</html>

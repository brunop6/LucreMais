<?php
    include 'includes/validacao_cookies.inc';
    include_once './classes/Usuario.php';
    include_once './classes/Estoque.php';
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $nomeUsuario = $_SESSION['nome_usuario'];
    $idUsuario = $_SESSION['id_usuario'];
    $nivelAcesso = $_SESSION['nivel_usuario'];
    $email = $_SESSION['email_usuario'];

    function preencherEntradas(){
        global $email;
        
        list($id, $item, $categoria, $quantidade, $unidadeMedida, $preco, $observacao, $data, $nome) = Estoque::selectEntradaEstoque($email);
        if(!empty($id)){
            $i = 0;
            foreach($id as $value){
                echo "<tr>";
                
                echo "<td>$value</td>";
                echo "<td>$item[$i]</td>";
                echo "<td>$categoria[$i]</td>";
                echo "<td>$quantidade[$i] $unidadeMedida[$i]</td>";
                echo "<td>R$ $preco[$i]</td>";
                echo "<td>$observacao[$i]</td>";
                echo "<td class='mais'>$data[$i]</td>";
                echo "<td class='mais'>$nome[$i]</td>";

                echo "</tr>";
                $i++;
            }
        }
    }
    function preencherBaixas(){
        global $email;

        list($id, $item, $categoria, $quantidade, $unidadeMedida, $preco, $observacao, $data, $nome) = Estoque::selectBaixaEstoque($email);
        if(!empty($id)){
            $i = 0;
            foreach($id as $value){
                echo "<tr>";
                
                echo "<td>$value</td>";
                echo "<td>$item[$i]</td>";
                echo "<td>$categoria[$i]</td>";
                echo "<td>$quantidade[$i] $unidadeMedida[$i]</td>";
                echo "<td>R$ $preco[$i]</td>";
                echo "<td>$observacao[$i]</td>";
                echo "<td class='mais'>$data[$i]</td>";
                echo "<td class='mais'>$nome[$i]</td>";

                echo "</tr>";
                $i++;
            }
        }
    }
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
                        echo '<li><a href="./Receitas/receitas.php">Receitas</a></li>';
                    }
                    if(Usuario::verificarMenu($idUsuario, "Financeiro")){
                        echo '<li><a href="./financeiro/financeiro.php">Financeiro</a></li>';
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
            <li><a href="./usuario/edita_usuario/edita_usuario.php">Conta</a></li>
            <?php
                if ($nivelAcesso == "Administrador") {
                    echo "<li><a href='./usuario/permissoes/permissoes.php'>Permissões</a></li>";
                }
            ?>
            <li><a href="logoff.php">Logoff</a></li>
        </ul>
    </div>

    <section>
        <?php
            list($id) = Estoque::selectEntradaEstoque($email);

            if(!empty($id)){
                echo '<button onclick="verMais()" class="btn-plus">Ver mais...</button>';
                echo '
                    <table style="margin-top: 10px; background-color: #002D55; border-collapse:collapse;"; border="1px">
                    <h1>Entradas</h1>
                    <tr>
                        <th>Id</th>
                        <th>Item</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Observação</th>
                        <th class="mais">Data</th>
                        <th class="mais">Usuário</th>
                    </tr>
                ';
                preencherEntradas();

                echo "</table>";
            }

            list($id) = Estoque::selectBaixaEstoque($email);

            if(!empty($id)){
                echo '
                    <table style="margin-top: 10px; background-color: #002D55; border-collapse:collapse;"; border="1px">
                    <h1>Baixas</h1>
                    <tr>
                        <th>Id</th>
                        <th>Item</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Observação</th>
                        <th class="mais">Data</th>
                        <th class="mais">Usuário</th>
                    </tr>
                ';
                preencherBaixas();

                echo "</table>";
            }
        ?>
        <script type="text/javascript" src="./js/verMais.js"></script>
    </section>
</body>
</html>
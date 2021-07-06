<?php
    define('menu', 'Itens');
    include_once "../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = $_SESSION['id_usuario'];
    $email = $_SESSION['email_usuario'];
    if(!Usuario::verificarMenu($idUsuario, menu)){
        header("Location: ./../Home.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estoque/estoque.css">
    <title>Item</title>
</head>
<body>
    <header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="../cadastro_item/cadastro_de_itens.php">Cadastrar itens</a></li>
                <li><a href="./categoria/categoria.php">Categoria</a></li>
                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            include_once '../classes/Item.php';
            include_once '../classes/Usuario.php';
            include_once '../classes/Categoria.php';
        
            function preencherItem(){
                global $email;
                list($id, $nomeItem, $quantidade,$descricaoCategoria,$quantidadeMinima, $unidadeMedida, $nomeUsuario) = Item::selectItensLista($email);
                if(!empty($nomeItem)){
                    $i = 0;
                    foreach($nomeItem as $nome){
                        echo "<tr>";
                    
                        echo "<td>$nome</td>";
                        echo "<td>$quantidade[$i] $unidadeMedida[$i]";
                        echo "<td>$descricaoCategoria[$i]</td>";
                        echo "<td>$quantidadeMinima[$i] $unidadeMedida[$i]</td>";
                        echo "<td class='mais'>$nomeUsuario[$i]</td>";
                        echo "<td><a href='./edita_item.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                }
            }
        ?>
        
        <button onclick="verMais()" class="btn-plus">Ver mais...</button>
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Quantidade mínima</th>
                <th class='mais'>Usuário</th>
                <th>Editar</th>
            </tr>     
            <?php   
                preencherItem();
            ?>
        </table>
        <script type="text/javascript" src="./../js/verMais.js"></script>
    </main>
</body>
</html>
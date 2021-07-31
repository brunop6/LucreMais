<?php
    define('menu', 'Fornecedores');
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
    <title>Fornecedor</title>
    <link rel="stylesheet" href="./fornecedor.css">
    <?php
        function preencherFornecedores(){
            global $email;
            include_once '../classes/Fornecedor.php';

            list($id, $nomeFornecedor, $email, $telefone, $cnpj, $endereco, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Fornecedor::selectFornecedores($email);

            if(!empty($nomeFornecedor)){
                $i = 0;
                foreach($nomeFornecedor as $fornecedor){
                    if($email[$i] == NULL){
                        $email[$i] = '';
                    }
                    if($cnpj[$i] == NULL){
                        $cnpj[$i] = '';
                    }
                    if($endereco[$i] == NULL){
                        $endereco[$i] = '';
                    }
                    echo "<tr>";
                    
                    echo "<td>$fornecedor</td>";
                    echo "<td>$email[$i]</td>";
                    echo "<td>$telefone[$i]</td>";
                    echo "<td>$cnpj[$i]</td>";
                    echo "<td>$endereco[$i]</td>";
                    echo "<td class='mais'>$dataCadastro[$i]</td>";
                    echo "<td class='mais'>$dataAtualizacao[$i]</td>";
                    echo "<td class='mais'>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_fornecedor.php?id=$id[$i]' style='color:#B9DEFF'>Editar</a></td>";

                    echo "</tr>";
                    $i++;
                }
            }
        }
    ?>
</head>
<body>
<header>
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">&#9776;</label>
        <nav class="menu">
            <ul>
                <li><a href="./cadastro_fornecedor/cadastro_fornecedor.php">Cadastrar fornecedor</a></li>
                <li><a href="../Home.php">Página Principal</a></li>
            </ul>
        </nav>
    </header>
    <h1 style="color: #B9DEFF;">Listagem de Fornecedores<br></h1>
    <main>
        <button onclick="verMais()" class="btn-plus">Ver mais...</button>

        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Nome </th>
                <th>E-mail </th>
                <th>Telefone</th>
                <th>CNPJ</th>
                <th>Endereço</th>
                <th class='mais'>Data Cadastro</th>
                <th class='mais'>Data Atualização</th>
                <th class='mais'>Usuário</th>
                <th>Editar</th>
                <?php
                    preencherFornecedores();
                ?>  
            </tr>
        </table>
        <script type="text/javascript" src="./../public/js/verMais.js"></script>
    </main>
</body>
</html>
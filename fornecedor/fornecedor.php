<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edita Fornecedor</title>
    <link rel="stylesheet" href="fornecedor.css">
    <?php
        function preencherFornecedores(){
            include_once '../classes/Fornecedor.php';

            list($id, $nomeFornecedor, $email, $telefone, $cnpj, $endereco, $dataCadastro, $dataAtualizacao, $nomeUsuario) = Fornecedor::selectFornecedores();

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
                    echo "<td>$dataCadastro[$i]</td>";
                    echo "<td>$dataAtualizacao[$i]</td>";
                    echo "<td>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_fornecedor.php?id=$id[$i]' style='color:rgb(173,144,0)'>Editar</a></td>";

                    echo "</tr>";
                    $i++;
                }
            }
        }
    ?>
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">
    <h1>Listagem de Fornecedor<br></h1>
    <main>
        <table style="width:100%; margin-top: 10px"; border="1px">
            <tr>
                <th>Nome </th>
                <th>E-mail </th>
                <th>Telefone</th>
                <th>CNPJ</th>
                <th>Endereço</th>
                <th>Data Cadastro</th>
                <th>Data Atualização</th>
                <th>Usuário</th>
                <th>Editar</th>
                <?php
                    preencherFornecedores();
                ?>  
            </tr>
        </table>
    </main>
</body>
</html>
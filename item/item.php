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
            
            $id = $_GET['id']; 
            function preencherItem($id){

          //  list($nomeItem, $quantidade, $idCategoria, $quantidadeMinima, $idUsuario) = Item::selectItensLista($id);
                list($nomeItem, $quantidade,$descricaoCategoria,$quantidadeMinima, $nomeUsuario) = Item::selectItensLista($id);
            if(!empty($nomeItem)){
                 
                $i = 0;
                foreach($nomeItem as $nome){
                    echo "<tr>";
                   
                    echo "<td>$nome</td>";
                    echo "<td>$quantidade[$i]";
                  //  echo "<td>$idCategoria[$i]</td>";
                    echo "<td>$descricaoCategoria[$i]</td>";
                    echo "<td>$quantidadeMinima[$i]</td>";
                  //  echo "<td>$idUsuario[$i]</td>";
                    echo "<td>$nomeUsuario[$i]</td>";
                    echo "<td><a href='./edita_item.php?id=$id[$i]' style='color:rgb(173,144,0)'>Editar</a></td>";

                    echo "</tr>";
                    $i++;
                }
            }
        }
    ?>
 
    
        <table style="width:100%; margin-top: 10px"; border="1px";>
            <tr>
             
                <th>Item</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Quantidade mínima</th>
                <th>Usuário</th>
                <th>Editar</th>
            </tr>     
        <?php   
                
                preencherItem($id);
            ?>
        </table>
    </main>
</body>
</html>
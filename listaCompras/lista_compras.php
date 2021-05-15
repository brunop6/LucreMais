<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Compras</title>
</head>
<body>
    <?php
        require_once '../classes/Estoque.php';
        $estoque = new Estoque();

        /*Verificação da variável opt
        *   
        * $opt = 1 -> Visualização direta no navegador
        * $opt = 2 -> Visualização do PDF
        */
        if(!isset($_GET['opt'])){
            $opt = 1;
        }else{
            $opt = $_GET['opt'];
        }

        if($estoque->retornar_itens_em_falta() != null){
            echo '<h1>Itens em Falta no Estoque</h1> <hr>';

            $itens = $estoque->retornar_itens_em_falta();

            foreach($itens as $i => $row){
                echo "
                    <p>
                        <input type='checkbox' id='item$i'>
                        <label for='item'>$row</label>
                    </p>
                ";
            }

            if($opt == 2){
                $estoque->gerar_lista_compras();
            }
        }else{
            echo '
                <h2>Seu Estoque está em dia!</h2>
                <br>
                <a href="../Home.php">Voltar para página principal</a>
            ';
        }
    ?>
</body>
</html>
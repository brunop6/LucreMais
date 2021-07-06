<?php
    define('menu', 'Estoque');
    include_once "../../classes/Usuario.php";

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $idUsuario = Usuario::selectId($_SESSION['nome_usuario']);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Compras</title>
    <style>
        body{
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <?php
        require_once '../../classes/Estoque.php';

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

        if(Estoque::retornar_itens_em_falta($email) != null){
            echo '<h1>Lista de Compras</h1> <hr>';

            $itens = Estoque::retornar_itens_em_falta($email);

            foreach($itens as $i => $row){
                echo "
                    <p>
                        <input type='checkbox' id='item$i'>
                        <label for='item'>$row</label>
                    </p>
                ";
            }

            if($opt == 2){
                Estoque::gerar_lista_compras();
            }
        }else{
            echo '
                <h2>Seu Estoque está em dia!</h2>
                <br>
                <a href="http://localhost/LucreMais/Home.php">Voltar para página principal</a>
            ';
        }
    ?>
</body>
</html>
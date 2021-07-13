<?php
    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!(array_key_exists ('nome_usuario' , $_SESSION))&&(array_key_exists ('senha_usuario' , $_SESSION))){
        header("Location: Login/login.php");
    }
    else {
        include __DIR__."./conecta_bd.inc";

        $usuario = $_SESSION['nome_usuario'];
        $senha = $_SESSION['senha_usuario'];

        $query = ("select * from usuario where nomeUsuario = '$usuario'");

        $resultado = mysqli_query($conexao, $query);

        $linhas = mysqli_num_rows($resultado);

        if($linhas == 0){
            header("Location: Login/login.php");
        }else{
            while($row = mysqli_fetch_array($resultado)){
                $res_senha = $row["senha"];
            }

            if($_SESSION["senha_usuario"] != $res_senha){
                header("Location: Login/login.php");
            }
        }

        mysqli_close($conexao);
    }
    
?>
<?php
    if(!isset($_POST['idAcao0'])){
        header('Location: ./../permissoes.php');
        die();
    }
    include_once './../../../classes/Usuario.php';

    for($i = 0; $i < 999; $i++){
        $indexId = 'idAcao'.$i;
        $indexInserir = 'inserir'.$i; 
        $indexEditar = 'editar'.$i; 
        $indexExcluir = 'excluir'.$i; 
        $indexConsultar = 'consultar'.$i; 

        if(isset($_POST["$indexId"])){
            $idAcao[$i]  = $_POST["$indexId"];
            if(isset($_POST["$indexInserir"])){
                $inserir[$i]  = 1;
            }else{
                $inserir[$i]  = 0;
            }

            if(isset($_POST["$indexEditar"])){
                $editar[$i]  = 1;
            }else{
                $editar[$i]  = 0;
            }

            if(isset($_POST["$indexExcluir"])){
                $excluir[$i]  = 1;
            }else{
                $excluir[$i]  = 0;
            }

            if(isset($_POST["$indexConsultar"])){
                $consultar[$i]  = 1;
            }else{
                $consultar[$i]  = 0;
            }
        }else{
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../permissoes.css">
    <title>Edição de ações</title>
</head>
<body>
    <?php
        $i = 0;
        foreach($idAcao as $id){            
            $resultado = Usuario::editarAcao($id, $inserir[$i], $editar[$i], $excluir[$i], $consultar[$i]);

            if(!$resultado){
                break;
            }
            $i++;
        }
        if($resultado){
            header('Location: ./../permissoes.php');
            die();
        }else{
            echo "<h3>$resultado</h3>";
            echo "<button onclick='window.location.href='./../permissoes.php''>Retornar às permissões</button>";
        }
    ?>
</body>
</html>
<?php
    if(isset($_POST['numUsuarios']) && $_POST['numUsuarios'] > 0){
        $numUsuarios = $_POST['numUsuarios'];

        include_once './../../../classes/Usuario.php';
    }else{
        header('Location: ./../permissoes.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./../../../public/css/inputs.css">

    <title>Edição de Permissões</title>
</head>
<body>
<?php
    for($i = 0; $i < $numUsuarios; $i++){
        $idUsuario = $_POST['usuario'.$i];
        $idNovoNivel = $_POST['nivelUsuario'.$i];
        $novoStatus = $_POST['statusUsuario'.$i];

        $resultado = Usuario::editarNivelAcesso($idUsuario, $idNovoNivel);

        if(!$resultado){
            echo $resultado;
            echo "<button onclick='window.location.href='./../permissoes.php''>Retornar às permissões</button>";
            break;
        }

        $resultado = Usuario::editarStatus($idUsuario, $novoStatus);

        if(!$resultado){
            echo $resultado;
            echo "<button onclick='window.location.href='./../permissoes.php''>Retornar às permissões</button>";
            break;
        }
    }
    if($resultado){
        header('Location: ./../permissoes.php');
        die();
    }
?>
</body>
</html>
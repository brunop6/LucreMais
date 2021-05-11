<?php
  $conexao = mysqli_connect("localhost", "root", "", "lucreMais");
  
  if(mysqli_connect_errno()){
    echo "Problemas para conectar no banco. Erro:";
    echo mysqli_connect_error();
    die();
  }
?>
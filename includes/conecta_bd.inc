<?php
  $conexao = mysqli_connect("localhost", "root", "", "lucremais");
  
  if(mysqli_connect_errno()){
    echo "Problemas para conectar no banco. Erro:";
    echo mysqli_connect_error();
    die();
  }
?>
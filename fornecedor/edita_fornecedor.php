<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edita Fornecedor</title>
    <link rel="stylesheet" href="fornecedor.css">
</head>
<body>
<img src="./../Logo.png" alt="Logo do site" width="14%">
    <h1>Editar de Fornecedor<br></h1>
    <form action="" method="POST">
        <p><input type="text" name="nomeFornecedor" placeholder="Nome do Fornecedor" id="em" required></p>
            
        <p><input type="email" name="email" placeholder="Email Fornecedor" required> </p>

        <p><input type="text" name="telefone" placeholder="Telefone" required></p>

        <p><input type="text" name="cnpj" placeholder="CNPJ" required></p>

        <p><input type="text" name="endereco" placeholder="Endereço Fornecedor" required></p>
           
        <p><input type="submit" value="Salvar" name="Salvar"></p>
        
        <input type="button" value="Cancelar" onclick="window.location.href='./fornecedor.php'">
    </form>
</body>
</html>
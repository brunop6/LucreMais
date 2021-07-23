<?php
include './../../../includes/validacao_cookies.inc';
include_once './../../../classes/Usuario.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$nivelUsuario = $_SESSION['nivel_usuario'];

if ($nivelUsuario != "Administrador") {
    header('Location: ./../../Home.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./aparencia_CN.css">

    <title>Novo nível</title>
</head>
<body>
    <br>
    <img src="./../../../Logo.png" alt="Logo do site" width="14%">
    <br>
    <br>
    <h1>Novo nível de acesso</h1>

    <form action="./cadastrar_nivel.php" method="POST">
        <p><input type="text" name="descricao" placeholder="Descrição do Nível" required></p>
        <hr>
        <br>
        <h1>Menus acessíveis: </h1>
        
        <p class="menu">
            <label for="estoque">Estoque: </label>
            <input type="checkbox" name="estoque" id="estoque">
            <div class="acoes">
                <hr>
                <fieldset>
                    <legend>Ações</legend>

                    <p>
                        <label for="estoque-inserir">Inserir: </label>
                        <input type="checkbox" name="estoque-inserir" id="estoque-inserir" checked>
                    </p>
                    <p>
                        <label for="estoque-editar">Cadastrar: </label>
                        <input type="checkbox" name="estoque-editar" id="estoque-editar" checked>
                    </p>
                    <p>
                        <label for="estoque-excluir">Excluir: </label>
                        <input type="checkbox" name="estoque-excluir" id="estoque-excluir" checked>
                    </p>
                </fieldset>
            </div>
        </p>
        <p class="menu">
            <label for="fornecedores">Fornecedores: </label>
            <input type="checkbox" name="fornecedores" id="fornecedores">
            
            <div class="acoes">
                <hr>
                <fieldset>
                    <legend>Ações</legend>

                    <p>
                        <label for="fornecedores-inserir">Inserir: </label>
                        <input type="checkbox" name="fornecedores-inserir" id="fornecedores-inserir" checked>
                    </p>
                    <p>
                        <label for="fornecedores-editar">Editar: </label>
                        <input type="checkbox" name="fornecedores-editar" id="fornecedores-editar" checked>
                    </p>
                    <p>
                        <label for="fornecedores-excluir">Excluir: </label>
                        <input type="checkbox" name="fornecedores-excluir" id="fornecedores-excluir" checked>
                    </p>
                </fieldset>
            </div>
        </p>
        <p class="menu">
            <label for="itens">Itens: </label>
            <input type="checkbox" name="itens" id="itens">
            
            <div class="acoes">
                <hr>
                <fieldset>
                    <legend>Ações</legend>

                    <p>
                        <label for="itens-inserir">Inserir: </label>
                        <input type="checkbox" name="itens-inserir" id="itens-inserir" checked>
                    </p>
                    <p>
                        <label for="itens-editar">Editar: </label>
                        <input type="checkbox" name="itens-editar" id="itens-editar" checked>
                    </p>
                    <p>
                        <label for="itens-excluir">Excluir: </label>
                        <input type="checkbox" name="itens-excluir" id="itens-excluir" checked>
                    </p>
                </fieldset>
            </div>
        </p>
        <p class="menu">
            <label for="receitas">Receitas: </label>
            <input type="checkbox" name="receitas" id="receitas">

            <div class="acoes">
                <hr>
                <fieldset>
                    <legend>Ações</legend>

                    <p>
                        <label for="receitas-inserir">Inserir: </label>
                        <input type="checkbox" name="receitas-inserir" id="receitas-inserir" checked>
                    </p>
                    <p>
                        <label for="receitas-editar">Editar: </label>
                        <input type="checkbox" name="receitas-editar" id="receitas-editar" checked>
                    </p>
                    <p>
                        <label for="receitas-excluir">Excluir: </label>
                        <input type="checkbox" name="receitas-excluir" id="receitas-excluir" checked>
                    </p>
                    <p>
                </fieldset>
            </div>
        </p>
        <p class="menu">
            <label for="financeiro">Financeiro: </label>
            <input type="checkbox" name="financeiro" id="financeiro">

            <div class="acoes">
                <hr>
                <fieldset>
                    <legend>Ações</legend>
                    
                    <p>
                        <label for="financeiro-inserir">Inserir: </label>
                        <input type="checkbox" name="financeiro-inserir" id="financeiro-inserir" checked>
                    </p>
                    <p>
                        <label for="financeiro-editar">Editar: </label>
                        <input type="checkbox" name="financeiro-editar" id="financeiro-editar" checked>
                    </p>
                    <p>
                        <label for="financeiro-excluir">Excluir: </label>
                        <input type="checkbox" name="financeiro-excluir" id="financeiro-excluir" checked>
                    </p>
                </fieldset>
            </div>
        </p>
        <br>
        <hr>

        <p>
            <input type="submit" value="Salvar">
            <input type="button" value="Voltar" onclick="window.location.href='./../permissoes.php'">
        </p>
    </form>
    <script type="text/javascript" src="./cadastro_nivel.js"></script>
</body>
</html>
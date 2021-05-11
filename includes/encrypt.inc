<?php
    //Função de encriptação e decriptação de senhas
    function encryptPassword($usuario, $email, $senha){
        //Chave da criptografia
        $salt = $email.strlen($usuario).$usuario.strlen($email);
        
        //Senha criptografada
        $output = crypt($senha, $salt);
        return $output;
    }
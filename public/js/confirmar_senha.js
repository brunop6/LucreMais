function confirmar_senha(){
    let senha = document.querySelector("#s");
    let confirmasenha = document.querySelector("#sc");

    if(senha.value != confirmasenha.value){
        confirmasenha.setCustomValidity("As senhas não coincidem!");
    }else{
        confirmasenha.setCustomValidity("");
    }
}
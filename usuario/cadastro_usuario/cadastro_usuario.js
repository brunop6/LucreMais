function confirmar_senha(){
    var senha = document.getElementById("s");
    var confirmasenha = document.getElementById("sc");

    if(senha.value != confirmasenha.value){
        confirmasenha.setCustomValidity("As senhas não coincidem");
    }else{
        confirmasenha.setCustomValidity("");
    }
}
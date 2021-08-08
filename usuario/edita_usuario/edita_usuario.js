let form = document.querySelector('#form-edit');

form.addEventListener('submit', function(event){
    event.preventDefault();

    if(confirmarEdicao()){
        form.submit();
    }else{
        location.reload();
    }
});

function confirmarEdicao(){
    let statusInativo = document.querySelector('#statusInativo');
    
    if(statusInativo.checked){
        let msg = "Ao confirmar a edição para o status \"Inativo\", você estará bloqueando sua conta até que algum administrador te desbloqueie. \n\nPara confirmar a operação digite \"CIENTE\":";
    
        let confirm = prompt(msg);
    
        if(confirm != "CIENTE"){
            alert("Operação cancelada!");
            return false
        }
    }
    return true;
}



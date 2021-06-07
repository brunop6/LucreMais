function validar_unidade_medida(){
    var select = document.getElementsByName("unidade_de_medida");

    if(select.value == "unidade_de_medida"){
        select.setCustomValidity("Selecione a unidade de medida válida");
        
    }else{
        select.setCustomValidity("");
    }
}
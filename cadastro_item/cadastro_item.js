function validar_unidade_medida(){
    var select = document.getElementById('unidadeMedida');

    if(select.value == "unidade_de_medida"){
        alert("Selecione a unidade de medida válida");
        select.focus();
    }
}
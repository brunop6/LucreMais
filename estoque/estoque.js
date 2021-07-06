function alterarExibicao() {
    let status = document.getElementById('status').value;
    let nome = document.getElementById('nome').value;
    let marca = document.getElementById('marca').value;
    let categoria = document.getElementById('categoria').value;
    let lote = document.getElementById('lote').value;
    let url = "?status=" + status;

    if(nome){
        url = url + "&nome="+nome;
    }
    if(marca){
        url = url + "&marca="+marca;
    }
    if(categoria){
        url = url + "&categoria="+categoria;
    }
    if(lote){
        url = url + "&lote="+lote;
    }
    window.location.href = url;
}
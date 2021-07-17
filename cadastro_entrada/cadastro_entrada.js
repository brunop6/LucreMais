function preencherCategorias(){
    var inputCategoria = document.getElementById('categoriaEntrada').value;

    if(inputCategoria.length>=3){
        $.ajax({
            url: 'selectCategoriaEntrada.php',
            method: 'POST',
            data:{categoriaEntrada: inputCategoria},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                var categoria = result;
                var datalist = document.getElementById('categorias');
                var options = datalist.children;
                var option = [];
                
                for1:
                for(var i = 0; i<categoria.length; i++){
                    for2:
                    for(var j = 0; j<options.length; j++){
                        if(categoria[i]==options[j].value) break for1;
                    }
                    option[i] = document.createElement('option');
                    option[i].value = categoria[i];
                    option[i].id = 'opt';
                    datalist.appendChild(option[i]);
                }
            }else{
                console.log('Busca (categoria) sem resultado...')
            }
        });
    }else{
        while(document.getElementById('opt') != null){
            document.getElementById('opt').remove();
        }
    }

}
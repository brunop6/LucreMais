function preencherCategorias(){
    var inputCategoria = document.getElementById('categoriaDespesa').value;

    if(inputCategoria.length>=3){
        $.ajax({
            url: 'selectCategoriaDespesa.php',
            method: 'POST',
            data:{categoriaDespesa: inputCategoria},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                var categoria = result;
                var datalist = document.getElementById('despesa');
                options = datalist.children;
                option = [];

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
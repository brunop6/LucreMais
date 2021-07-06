function preencherCategorias(){
    var inputCategoria = document.getElementById('categoriaRecibo').value;

    if(inputCategoria.length >= 3){
        //Envio da variável JS para o arquivo PHP
        $.ajax({
            url: './categoria/selectCategorias.php',
            method: 'POST',
            data: {categoria: inputCategoria},
            dataType: 'json'
        }).done(function(result){ //result = retorno do arquivo PHP
            if(result != null){
                var categoria = result;
                var datalist = document.getElementById('categorias');
                var options = datalist.children; //Elementos filhos do datalist categorias
                var option = [];

                for1:
                for(var i = 0; i < categoria.length; i++){
                    for2:
                    for(var j = 0; j < options.length; j++){
                        /**
                         * Se a categoria a ser apresentada for igual a uma categoria já apresentada anteriormente
                         * a adição não sera refeita
                         */
                        if(categoria[i] == options[j].value) break for1;
                    }  
                    option[i] = document.createElement('option');
                    option[i].value = categoria[i];
                    option[i].id = 'opt';
                    datalist.appendChild(option[i]);
                }
            }else{
                console.log('Busca (categoria) sem resultados...')
            }    
        });
    }else{ 
      while(document.getElementById('opt') != null){
        document.getElementById('opt').remove();
      }
    }
}
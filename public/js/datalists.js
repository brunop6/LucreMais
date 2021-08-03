function preencherCategorias(){
    var inputCategoria = document.getElementById('categoria').value;

    if(inputCategoria.length >= 3){
        //Envio da variável JS para o arquivo PHP
        $.ajax({
            url: '/LucreMais/public/ajax/selectCategorias.php',
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

function preencherCategoriaDespesa(){
    let inputCategoria = document.getElementById('categoriaDespesa').value;

    if(inputCategoria.length >= 3){
        $.ajax({
            url: '/LucreMais/public/ajax/selectCategoriaDespesa.php',
            method: 'POST',
            data: {categoriaDespesa: inputCategoria},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                let categoria = result;
                let datalist = document.getElementById('categorias');
                let options = datalist.children;
                let option = [];

                for1:
                for(let i = 0; i < categoria.length; i++){
                    for2:
                    for(let j = 0; j < options.length; j++){
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

function preencherCategoriaReceita(){
    var inputCategoria = document.getElementById('categoriaReceita').value;

    if(inputCategoria.length >= 3){
        //Envio da variável JS para o arquivo PHP
        $.ajax({
            url: '/LucreMais/public/ajax/selectCategoriaReceita.php',
            method: 'POST',
            data: {categoriaReceita: inputCategoria},
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

function preencherFornecedores(){
    let inputFornecedor = document.getElementById('fornecedor').value;
    
    if(inputFornecedor.length >= 3){
        $.ajax({
            url: '/LucreMais/public/ajax/selectFornecedores.php',
            method: 'POST',
            data: {fornecedor: inputFornecedor},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                let fornecedor = result;
                let datalist = document.getElementById('fornecedores');
                let options = datalist.children;
                let option = [];

                for1:
                for(let i = 0; i < fornecedor.length; i++){
                    for2:
                    for(let j = 0; j < options.length; j++){
                        if(fornecedor[i] == options[j].value) break for1;
                    }  
                    option[i] = document.createElement('option');
                    option[i].value = fornecedor[i];
                    option[i].id = 'optFornecedor';
                    datalist.appendChild(option[i]);
                }
            }else{
                console.log('Busca (fornecedor) sem resultados...')
            }    
        });
    }else{ 
      while(document.getElementById('optFornecedor') != null){
        document.getElementById('optFornecedor').remove();
      }
    }
}

function preencherItens(){  
    let inputItem = document.getElementById('item').value;

    if(inputItem.length >= 3){
        $.ajax({
            url: '/LucreMais/public/ajax/selectItens.php',
            method: 'POST',
            data: {item: inputItem},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                let item = result;
                let datalist = document.getElementById('itens');
                let options = datalist.children;
                let option = [];

                for1:
                for(let i = 0; i < item.length; i++){
                    for2:
                    for(let j = 0; j < options.length; j++){
                        if(item[i] == options[j].value) break for1;
                    }  
                    option[i] = document.createElement('option');
                    option[i].value = item[i];
                    option[i].id = 'optItem';
                    datalist.appendChild(option[i]);
                }
            }else{
                console.log('Busca (item) sem resultados...')
            }    
        });
    }else{ 
        while(document.getElementById('optItem') != null){
          document.getElementById('optItem').remove();
        }
    }
}
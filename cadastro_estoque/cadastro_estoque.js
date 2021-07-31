function preencherFornecedores(){
    var inputFornecedor = document.getElementById('fornecedor').value;
    
    if(inputFornecedor.length >= 3){
        //Envio da variável JS para o arquivo PHP
        $.ajax({
            url: './../public/ajax/selectFornecedores.php',
            method: 'POST',
            data: {fornecedor: inputFornecedor},
            dataType: 'json'
        }).done(function(result){ //result = retorno do arquivo PHP
            if(result != null){
                var fornecedor = result;
                var datalist = document.getElementById('fornecedores');
                var options = datalist.children; //Elementos filhos do datalist
                var option = [];

                for1:
                for(var i = 0; i < fornecedor.length; i++){
                    for2:
                    for(var j = 0; j < options.length; j++){
                        /**
                         * Se a opção a ser apresentada for igual a uma opção já apresentada anteriormente
                         * a adição não sera refeita
                         */
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
    var inputItem = document.getElementById('item').value;
    if(inputItem.length >= 3){
        $.ajax({
            url: './../public/ajax/selectItens.php',
            method: 'POST',
            data: {item: inputItem},
            dataType: 'json'
        }).done(function(result){
            if(result != null){
                var item = result;
                var datalist = document.getElementById('itens');
                var options = datalist.children;
                var option = [];

                for1:
                for(var i = 0; i < item.length; i++){
                    for2:
                    for(var j = 0; j < options.length; j++){
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
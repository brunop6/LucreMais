function inserirIngrediente(){
    $("#inserir").remove();

    let custo = 'Custo: R$ 0,00 + 30% ➞ R$ 0,00';

    if($("#custo").text() != ''){
        custo = $('#custo').text();

        $("#custo").remove(); 
    }
     
    
    //Controle da quantidade de ingredientes
    let pNum = $("#numIngred");
    let numIngred = parseInt(pNum.text());

    //Novos elementos
    let p1 = document.createElement("p");
    let p2 = document.createElement("p");
    let p3 = document.createElement("p");
    let inputi = document.createElement("input");
    let inputq = document.createElement("input");
    let inserir = document.createElement("button");   
    let select = document.createElement("select");
    let option1 = document.createElement("option");
    let option2 = document.createElement("option");
    let option3 = document.createElement("option");
    let option4 = document.createElement("option");
    let option5 = document.createElement("option");
    let option6 = document.createElement("option");
    let option7 = document.createElement("option");
    let option8 = document.createElement("option");
    let option9 = document.createElement("option");
    let fieldset = document.createElement("fieldset");
    let legend = document.createElement("legend");
    let h3 = document.createElement("h3");

    inputi.type = "text";
    inputi.name = "ingrediente"+numIngred;
    inputi.className = 'ingrediente-'+numIngred;
    inputi.placeholder = numIngred+"° Ingrediente";
    
    inputq.type = "number";
    inputq.step = "0.1";
    inputq.placeholder = "Quantidade";
    inputq.name = "quantidade"+numIngred;
    inputq.id = "quantidade-"+numIngred;

    select.name = "unidade_de_medida"+numIngred;
    select.id = "unidade_de_medida-"+numIngred;
    
    option1.textContent = "Unidade de Medida";
    option1.value = "unidade_de_medida";
    option2.textContent = "ML";
    option2.value = "ml";
    option3.textContent = "Grama";
    option3.value = "gramas";
    option4.textContent = "Colher de Sopa";
    option4.value = "colher_de_sopa";
    option5.textContent = "Colher de Chá"
    option5.value = "colher_de_cha";
    option6.textContent = "Colher de Café";
    option6.value = "colher_de_café";
    option7.textContent = "Xícara";
    option7.value = "xicara";
    option8.textContent = "Unidade(s)";
    option8.value = "unidade(s)";
    option9.textContent = "Quilo";
    option9.value = "quilo(s)";

    legend.textContent = "R$ 0,00";
    legend.id = "legend-"+numIngred;

    h3.id = 'custo';
    h3.textContent = custo;

    inserir.textContent = "Inserir ingrediente";
    inserir.id = "inserir";

    inserir.addEventListener("click", inserirIngrediente);

    //Função para a alternância do funcionamento do datalist
    inputi.addEventListener('focus', function(event){
        let lastItem = document.querySelector('#item');
        let datalist = document.querySelector('#itens');
        
        datalist.childNodes.forEach(function(child) {
            child.remove();
        });

        if(lastItem){
            lastItem.removeAttribute('id');
            lastItem.removeAttribute('list');
        }

        this.setAttribute('id', 'item');
        this.setAttribute('list', 'itens');
    });

    //Adição das funções de cálculo
    inputi.addEventListener('input', function(){
        preencherItens();

        if(this.value.length >= 3){
            let index = this.className.substring(this.className.search('-') + 1, this.className.length);
            
            calcularItem(index, this.value, $('#quantidade-'+index).val(), $('#unidade_de_medida-'+index).val(), numIngred);
        }
    });

    inputq.addEventListener('input', function(){
        let index = this.id.substring(this.id.search('-') + 1, this.id.length);

        calcularItem(index, $('.ingrediente-'+index).val(), this.value, $('#unidade_de_medida-'+index).val(), numIngred);
    });

    select.addEventListener('change', function(){
        let index = this.id.substring(this.id.search('-') + 1, this.id.length);

        calcularItem(index, $('.ingrediente-'+index).val(), $('#quantidade-'+index).val(), this.value, numIngred);
    });

    //Atualização da página
    let form = document.getElementById("formulario");

    form.appendChild(fieldset);
    form.appendChild(p3);

    fieldset.appendChild(legend);
    fieldset.appendChild(p1);
    fieldset.appendChild(p2);
    fieldset.appendChild(select);
    
    p1.appendChild(inputi);
    p2.appendChild(inputq);
    p3.appendChild(h3);
    p3.appendChild(inserir);

    select.appendChild(option1);
    select.appendChild(option8);
    select.appendChild(option2);
    select.appendChild(option3);
    select.appendChild(option4);
    select.appendChild(option5);
    select.appendChild(option6);
    select.appendChild(option7);
    select.appendChild(option9);

    document.body.appendChild(form);

    numIngred++;
    pNum.text(numIngred);
}

function calcularItem(id, nome, quantidade, unMedida, numItens){
    $.ajax({
        url: '/LucreMais/public/ajax/selectCustoItem.php',
        method: 'POST',
        data: {
            item: nome.toUpperCase(),
            quantidade: quantidade,
            unidadeMedida: unMedida.toUpperCase()
        },
        dataType: 'json'
    }).done(function(result){
        $('#legend-'+id).text(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(result));
        $('#custo').text('Custo: R$ 0,00 + 30% ➞ R$ 0,00');

        for(let i = 1; i < numItens; i++){
            let value = parseFloat($('#custo').text().substring(10, $('#custo').text().search('[+]') - 1).replace(',', '.'));
            
            value += parseFloat($('#legend-'+i).text().substring(3, $('#legend-'+i).text().length).replace(',', '.'));

            let totalValue = value + value * 0.3;
    
            $('#custo').text('Custo: ' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(value) + ' + 30% ➞ '+ new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(totalValue));
        }
    }).fail(function(){
        $('#legend-'+id).text('R$ 0,00');
        $('#custo').text('Custo: R$ 0,00 + 30% ➞ R$ 0,00');

        for(let i = 1; i < numItens; i++){
            let value = parseFloat($('#custo').text().substring(10, $('#custo').text().search('[+]') - 1).replace(',', '.'));
            
            value += parseFloat($('#legend-'+i).text().substring(3, $('#legend-'+i).text().length).replace(',', '.'));

            let totalValue = value + value * 0.3;
    
            $('#custo').text('Custo: ' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(value) + ' + 30% ➞ '+ new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(totalValue));
        }
    });
}

window.onload = inserirIngrediente;
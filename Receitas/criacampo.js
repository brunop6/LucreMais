function inseriringrediente(){
    document.getElementById("inserir").remove();  
    
    //Controle da quantidade de ingredientes
    var pNum = document.getElementById("numIngred")
    var numIngred = parseInt(pNum.textContent);
    numIngred++;

    //Novos elementos
    var p1 = document.createElement("p");
    var p2 = document.createElement("p");
    var p3 = document.createElement("p");
    var inputi = document.createElement("input");
    var inputq = document.createElement("input");
    var inserir = document.createElement("button");   
    var select = document.createElement("select");
    var option1 = document.createElement("option");
    var option2 = document.createElement("option");
    var option3 = document.createElement("option");
    var option4 = document.createElement("option");
    var option5 = document.createElement("option");
    var option6 = document.createElement("option");
    var option7 = document.createElement("option");

    inputi.type = "text";
    inputi.name = "ingrediente"+numIngred;
    inputi.placeholder = numIngred+"° Ingrediente";
    
    inputq.type = "number";
    inputq.placeholder = "Quantidade";

    option1.textContent = "Unidade de Medida";
    option1.value = "unidade_de_medida";
    option2.textContent = "ML";
    option2.value = "ml";
    option3.textContent = "Grama";
    option3.value = "grama";
    option4.textContent = "Colher de Sopa";
    option4.value = "colher_de_sopa";
    option5.textContent = "Colher de Chá"
    option5.value = "colher_de_cha";
    option6.textContent = "Colher de Café";
    option6.value = "colher_de_café";
    option7.textContent = "Xícara";
    option7.value = "xicara";

    inserir.textContent = "Inserir ingrediente";
    inserir.id = "inserir";
    inserir.addEventListener("click", inseriringrediente);

    var form = document.getElementById("formulario");

    form.appendChild(p1);
    form.appendChild(p2);
    form.appendChild(select);
    form.appendChild(p3);

    p1.appendChild(inputi);
    p2.appendChild(inputq);
    p3.appendChild(inserir);

    select.appendChild(option1);
    select.appendChild(option2);
    select.appendChild(option3);
    select.appendChild(option4);
    select.appendChild(option5);
    select.appendChild(option6);
    select.appendChild(option7);

    document.body.appendChild(form);

    pNum.textContent = numIngred;
}
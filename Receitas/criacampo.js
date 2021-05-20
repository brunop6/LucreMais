function inseriringrediente(){
    document.getElementById("inserir").remove();

    var p1 = document.createElement("p");
    var p2 = document.createElement("p");
    var inputi = document.createElement("input");
    var inserir = document.createElement("button");
    var inputq = document.createElement("input");
    var select = document.createElement("select");
    var option = document.createElement("option");

    inputi.placeholder = "Ingrediente";
    inserir.textContent = "Inserir ingrediente";
    inserir.id = "inserir";
    inserir.addEventListener("click", inseriringrediente);

    inputq.type = "number";
    inputq.placeholder = "Quantidade";

    option

    var form = document.getElementById("formulario");

    form.appendChild(p1);
    p1.appendChild(inputi);
    form.appendChild(p2);
    p2.appendChild(inputq);
    form.appendChild(select);
    select.appendChild(option);

    form.appendChild(inserir);

    document.body.appendChild(form);
}
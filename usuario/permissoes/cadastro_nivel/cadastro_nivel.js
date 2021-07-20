function alternaVisualizacao(checkbox, index){
    if(checkbox.checked){
        acao[index].hidden = false
    }else{
        acao[index].hidden = true
    }
}

let acao = document.getElementsByClassName("acoes");
let estoque = document.getElementById('estoque');
let fornecedores = document.getElementById('fornecedores');
let itens = document.getElementById('itens');
let receitas = document.getElementById('receitas');
let financeiro = document.getElementById('financeiro');

for(let i = 0; i < acao.length; i++){
    acao[i].hidden = true;
}

estoque.addEventListener("click", function(){
    alternaVisualizacao(this, 0);
});
fornecedores.addEventListener("click", function(){
    alternaVisualizacao(this, 1);
});
itens.addEventListener("click", function(){
    alternaVisualizacao(this, 2);
});
receitas.addEventListener("click", function(){
    alternaVisualizacao(this, 3);
});
financeiro.addEventListener("click", function(){
    alternaVisualizacao(this, 4);
});
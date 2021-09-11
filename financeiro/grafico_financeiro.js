let emailUsuario = document.querySelector("#email-usuario").textContent;

/* $(document).on('click', '#filtrar-grafico', function(){
    $.ajax({
        url: './../public/ajax/selectFinanceiro.php',
        type: 'POST',
        data:{
            dataInicial: $('#buscar-data-inicio').val(),
            dataFinal: $('#buscar-data-final').val(),
        },
        success: function(resposta){
            let receitas = result[0][0];
            let despesas = result[1][0];
            let lucros = [];
            let meses = [];
        
            //Conversão dos meses em valor numérico para forma escrita
            if(result[0][1]){
                result[0][1].forEach(function(value) {
                    meses.push(monthName(value));
                });
            }
            //Cálculos dos lucros
            receitas.forEach(function(value, index){
                lucros.push(value - despesas[index]);
            });
        
            //Renderização do gráfico
            if(meses.length > 0){
                renderChart(meses, receitas, despesas, lucros);
            }else{
                console.log('Sem dados financeiros...');
                document.querySelector('.chart-container').remove();
            }
        }
    })
}) */

$.ajax({
    url: './../public/ajax/selectFinanceiro.php',
    method: 'POST',
    data: {email: emailUsuario},
    dataType: 'json'
}).done(function(result){ //result = retorno do arquivo PHP
    //array[x][0] -> valores int/double
    //array[x][1] -> meses int
    let receitas = result[0][0];
    let despesas = result[1][0];
    let lucros = [];
    let meses = [];

    //Conversão dos meses em valor numérico para forma escrita
    if(result[0][1]){
        result[0][1].forEach(function(value) {
            meses.push(monthName(value));
        });
    }
    //Cálculos dos lucros
    receitas.forEach(function(value, index){
        lucros.push(value - despesas[index]);
    });

    //Renderização do gráfico
    if(meses.length > 0){
        renderChart(meses, receitas, despesas, lucros);
    }else{
        console.log('Sem dados financeiros...');
        document.querySelector('.chart-container').remove();
    }
});

function renderChart(meses, receitas, despesas, lucros){
    let ctx = document.getElementById('chart');

    //Instanciação do objeto gráfico
    let chart = new Chart(ctx, {
        //Tipo de gráfico
        type: 'bar',
        data: {
            //Valores de referência do eixo X
            labels: meses,

            //Valores do gráfico
            datasets: [{
                label: 'Receitas',
                data: receitas,

                borderWidth: 2,
                borderRadius: 5,
                borderColor: "rgba(3, 185, 3, 1)",

                backgroundColor: "rgba(3, 185, 3, 0.175)",

                order: 1
            },
            {
                label: 'Despesas',
                data: despesas,

                borderWidth: 2,
                borderRadius: 5,
                borderColor: "rgba(190, 0, 0, 1)",
                
                backgroundColor: "rgba(190, 0, 0, 0.2)",

                order: 2
            },
            {
                label: 'Lucro',
                data: lucros,

                //Borda tracejada
                borderDash: [5, 5],
                borderWidth: 2,
                borderColor: "rgba(185, 185, 0, 1)",

                backgroundColor: "rgba(185, 185, 0, 0.2)",

                //Gráfico em linha
                type: 'line',
                tension: 0.5,

                //Tamanho do ponto
                pointRadius: 8,
                pointStyle: 'star',
                order: 3
            }]
        },
        options: {
            plugins: {
                //Título do gráfico
                title: {
                    display: true,
                    position: 'top',

                    text: 'Auditoria Financeira',
                    font: {
                        size: 20
                    },
                    color: 'Black',
                },

                //Legendas dos datasets
                legend: {
                    display: true,
                    position: 'right',
                    //Configuração dos rótulos das legendas
                    labels: {
                        //Usar o estilo definido no dataset
                        usePointStyle: true,

                        font: {
                            size: 14
                        },
                        color: 'black'
                    }
                },
                
                //Menu de informações ao passar o mouse pelo gráfico
                tooltip: {
                    backgroundColor: '#002D55',

                    //Exibir tooltip acima do item próximo do mouse
                    position: 'nearest',
                    enabled: true,                

                    //Exibir estilo de ponto do dataset
                    usePointStyle: true,
                    
                    //Formatação dos valores do tooltip
                    callbacks: {
                        label: function(toolTipItem){
                            return new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(toolTipItem.raw);
                        }
                    }
                }
            },

            //Modo de interação com o gráfico
            interaction: {
                //Geração de tooltip pelo índice X
                mode: 'index',
                axis: 'x'
            },

            //Config. dos eixos laterais do gráfico
            scales: {
                x: {
                    //Valores de referência do eixo X (config)
                    ticks: {
                        color: 'black',
                        font: {
                            weight: 'bold'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Últimos 5 meses',
                        color: 'black',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    //Valores de referência do eixo Y (config)
                    ticks: {
                        callback: function (value) {
                            return new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL' }).format(value);
                        },
                        color: 'black'
                    }
                }
            }
        }
    });
}
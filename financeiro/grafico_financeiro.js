//Contexto do gráfico (elemento <canvas>)
let ctx = document.getElementById('chart');

//Declaração do gráfico
let chart = new Chart(ctx, {
    //Tipo de gráfico
    type: 'bar',
    data: {
        //Valores de referência do eixo X
        labels: ["Março", "Abril", "Maio", "Junho", "Julho"],

        //Valores do gráfico
        datasets: [{
            label: 'Entradas',
            data: [320.97, 597.48, 255.74, 433.48, 227.75],

            borderWidth: 2,
            borderRadius: 5,
            borderColor: "rgba(3, 185, 3, 1)",

            backgroundColor: "rgba(3, 185, 3, 0.175)",

            order: 1
        },
        {
            label: 'Despesas',
            data: [160, 357.22, 98, 333.65, 349.70],

            borderWidth: 2,
            borderRadius: 5,
            borderColor: "rgba(190, 0, 0, 1)",
            
            backgroundColor: "rgba(190, 0, 0, 0.2)",

            order: 2
        },
        {
            label: 'Lucro',
            data: [160.97, 240.26, 157.74, 99.83, -121.95],

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

                text: 'Relatório Mensal',
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
                        //console.log(toolTipItem);

                        //Retorno do valor "cru" do item
                        return 'R$ ' + toolTipItem.raw;
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
                    color: 'black'
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
                        return 'R$ ' + value;
                    },
                    color: 'black'
                }
            }
        }
    }
});
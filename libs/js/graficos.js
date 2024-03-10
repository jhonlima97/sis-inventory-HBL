function getNumEquiposBar1() {
    $.ajax({
        url: '../controllers/graficos/num_equipos.php',
        type: 'POST',
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo = [];
            let cantidad = [];
            let data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
            }
            CreateGrafico(equipo,cantidad, 'bar','x','GRÁFICO DE BARRAS VERTICAL DE EQUIPOS');
        }
    })
}

// Grafico de bar Horizontal
function getNumEquiposBar2() {
    $.ajax({
        url: '../controllers/graficos/num_equipos.php',
        type: 'POST',
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo = [];
            let cantidad = [];
            const data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
            }
            CreateGrafico(equipo,cantidad, 'bar','y','GRÁFICO DE BARRAS HORIZONTAL DE EQUIPOS');
        }
        
    })
}

let myChart = null; // Declara myChart fuera de las funciones

function CreateGrafico(equipo, cantidad, type,indexAxis, header) {
    const ctx = document.getElementById('myChart');
    
    // Destruye el gráfico anterior si existe
    if (myChart != null) {
        myChart.destroy();
    }
    
    myChart = new Chart(ctx, {
        type: type,
        data:{
            labels: equipo,
            datasets: [{
                label: header,
                data: cantidad,
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(215, 200, 100, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: indexAxis, //tipo de bar
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}




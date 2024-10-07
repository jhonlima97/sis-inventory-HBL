$(document).ready(function() {
    getNumEquiposBar1();
    getNumEquiposBar2();
    getNumEquiposPie3();
    getNumEquiposPie4();
});

// Grafico tipo bar Vertical
function getNumEquiposBar1() {
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data: { accion: 'num_equipos' }
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo   = [];
            let cantidad = [];
            let colors   = [];
            let data     = JSON.parse(resp);
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors, 'bar', 'x', 'GRÁFICO BAR VERTICAL', 'myChart1', false);
        }
    })
}
// Grafico tipo bar Horizontal
function getNumEquiposBar2() {
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data: { accion: 'num_equipos' }
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo = [];
            let cantidad = [];
            let colors = [];
            const data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors,'bar','y','GRÁFICO BAR HORIZONTAL','myChart2', false);
        }
        
    })
}
// Grafico Pastel tipo pie
function getNumEquiposPie3() {
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data: { accion: 'num_equipos' }
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo   = [];
            let cantidad = [];
            let colors   = [];
            const data   = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo,cantidad, colors, 'pie','', 'GRÁFICO PASTEL', 'myChart3', true);
        }
        
    })
}
// Grafico Pastel tipo doughnut
function getNumEquiposPie4() {
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data: { accion: 'num_equipos' }
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo = [];
            let cantidad = [];
            let colors = [];
            const data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo,cantidad, colors,'doughnut','','GRÁFICO DOUGHNUT','myChart4', true);
        }
        
    })
}

let myChart1 = null; // Declara myChart fuera de las funciones
let myChart2 = null; // Declara myChart fuera de las funciones
let myChart3 = null; // Declara myChart fuera de las funciones
let myChart4 = null; // Declara myChart fuera de las funciones

function CreateGrafico(equipo, cantidad, colors, type, indexAxis, header, chartId, showLegend = true) {
    const ctx = document.getElementById(chartId);

    // Destruye el gráfico anterior si existe
    if (window[chartId] instanceof Chart) {
        window[chartId].destroy();
    }

    const commonConfig = {
        type: type,
        data: {
            labels: equipo,
            datasets: [{
                label: 'Cantidad',
                data: cantidad,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: header,
                    font: {
                        size: 16
                    },
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                legend: {
                    display: showLegend,
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                }
            }
        }
    };

    // Ajustes para gráficos de barras
    if (type === 'bar') {
        commonConfig.options.indexAxis = indexAxis;
        commonConfig.options.scales = {
            y: {
                beginAtZero: true
            }
        };
    }

    window[chartId] = new Chart(ctx, commonConfig);
}


// Gerenate color random JS
function generateNumber(number) {
    return (Math.random()*number).toFixed(0);
}
function colorRGB() {
    let coolors = "("+generateNumber(255)+"," + generateNumber(255) + "," + generateNumber(255) + ")";
    return "rgb" + coolors;
}

////////////////////////////////////// FUNCIONES PARA GRAFICOS CON PARAMETROS////////////////////////////////

getAnio();
function MostrarGraficosParams(){
    let anio = $("#select-anio").val();
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data:{
            accion: 'grafico_params',
            anio: anio
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);
        if(data.length > 0) {
            getGraficoParams1();
            getGraficoParams2();
            getGraficoParams3();
            getGraficoParams4();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Perdón...',
                text: 'No hay desplazamientos para el año seleccionado.'
            });
            // alert("No hay desplazamientos para el año seleccionado.");
        }
    })
}
function getAnio() {
    let midate = new Date();
    let anio = midate.getFullYear();
    let cadena = "";
    for (let i=2023;i < anio+1; i++) {
        cadena+="<option value="+i+">"+i+"</option>";
    }
    $("#select-anio").html(cadena);
}

// Grafico tipo bar Vertical
function getGraficoParams1() {
    let anio = $("#select-anio").val();
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data:{
            accion: 'grafico_params',
            anio: anio
        }
    }).done(function(resp) {
        if(resp.length>0) {
            //let labels = [];
            let equipo = [];
            //let responsable = [];
            let cantidad = [];
            let colors = [];
            let data = JSON.parse(resp);
            console.log(JSON.stringify(data));
            for (let i = 0; i < data.length; i++) {
                //labels.push(data[i].new_responsable + ' (' + data[i].equipo + ')');
                equipo.push(data[i].equipo);
                //responsable.push(data[i].new_responsable);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors,'bar','x','GRÁFICO BAR VERTICAL','myChart1_param', false);
        }   
    })
}
// Grafico Pastel  Desplazamientos
function getGraficoParams2() {
    let anio = $("#select-anio").val();

    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data:{
            accion: 'grafico_params',
            anio: anio
        }
    }).done(function(resp) {
        if(resp.length>0) {
            //let labels = [];
            let equipo = [];
            //let responsable = [];
            let cantidad = [];
            let colors = [];
            let data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                //labels.push(data[i].new_responsable + ' (' + data[i].equipo + ')');
                equipo.push(data[i].equipo);
                //responsable.push(data[i].new_responsable);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors,'pie','','GRÁFICO PASTEL','myChart2_param', false);
        }   
    })
}
// Grafico doughnut Desplazamientos
function getGraficoParams3() {
    let anio = $("#select-anio").val();
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data:{
            accion: 'grafico_params',
            anio: anio
        }
    }).done(function(resp) {
        if(resp.length>0) {
            //let labels = [];
            let equipo = [];
            //let responsable = [];
            let cantidad = [];
            let colors = [];
            let data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                //labels.push(data[i].new_responsable + ' (' + data[i].equipo + ')');
                equipo.push(data[i].equipo);
                //responsable.push(data[i].new_responsable);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors,'doughnut','','GRÁFICO DOUGHNUT','myChart3_param', false);
        }   
    })
}
// Grafico bar Horizontal Desplazamientos
function getGraficoParams4() {
    let anio = $("#select-anio").val();
    $.ajax({
        url: '../controllers/graficos/graficos_controller.php',
        type: 'POST',
        data:{
            accion: 'grafico_params',
            anio: anio
        }
    }).done(function(resp) {
        if(resp.length>0) {
            //let labels = [];
            let equipo = [];
            //let responsable = [];
            let cantidad = [];
            let colors = [];
            let data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                //labels.push(data[i].new_responsable + ' (' + data[i].equipo + ')');
                equipo.push(data[i].equipo);
                //responsable.push(data[i].new_responsable);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo, cantidad, colors,'bar','y','GRÁFICO BAR HORIZONTAL','myChart4_param', false);
        }   
    })
}
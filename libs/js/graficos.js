$(document).ready(function() {
    getNumEquiposBar1();
    getNumEquiposBar2();
    getNumEquiposPie3();
    getNumEquiposPie4();
});

// Grafico tipo bar Vertical
function getNumEquiposBar1() {
    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/num_equipos.php',
        type: 'POST',
    }).done(function(resp) {
        if(resp.length>0) {
            let equipo = [];
            let cantidad = [];
            let colors = [];
            let data = JSON.parse(resp);
            
            for (let i = 0; i < data.length; i++) {
                equipo.push(data[i].equipo);
                cantidad.push(data[i].cantidad);
                colors.push(colorRGB());
            }
            CreateGrafico(equipo,cantidad, colors,'bar','x','GRÁFICO VERTICAL DE EQUIPOS','myChart1');
        }
    })
}

// Grafico tipo bar Horizontal
function getNumEquiposBar2() {
    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/num_equipos.php',
        type: 'POST',
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
            CreateGrafico(equipo,cantidad, colors,'bar','y','GRÁFICO HORIZONTAL DE EQUIPOS','myChart2');
        }
        
    })
}

// Grafico Pastel tipo pie
function getNumEquiposPie3() {
    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/num_equipos.php',
        type: 'POST',
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
            CreateGrafico(equipo,cantidad, colors, 'pie','','GRÁFICO PASTEL DE EQUIPOS','myChart3');
        }
        
    })
}


// Grafico Pastel tipo doughnut
function getNumEquiposPie4() {
    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/num_equipos.php',
        type: 'POST',
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
            CreateGrafico(equipo,cantidad, colors,'doughnut','','GRÁFICO DOUGHNUT DE EQUIPOS','myChart4');
        }
        
    })
}

let myChart1 = null; // Declara myChart fuera de las funciones
let myChart2 = null; // Declara myChart fuera de las funciones
let myChart3 = null; // Declara myChart fuera de las funciones
let myChart4 = null; // Declara myChart fuera de las funciones

function CreateGrafico(equipo, cantidad, colors,type,indexAxis, header, chartId) {
    const ctx = document.getElementById(chartId);
   
    // Destruye el gráfico anterior si existe
    if (window[chartId] instanceof Chart) {
        window[chartId].destroy();
    }

    window[chartId] = new Chart(ctx, {
        type: type,
        data:{
            labels: equipo,
            datasets: [{
                label: header,
                data: cantidad,
                backgroundColor:colors,
                borderColor:colors,
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
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/controller_param.php',
        type: 'POST',
        data:{
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
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/controller_param.php',
        type: 'POST',
        data:{
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
            CreateGrafico(equipo, cantidad, colors,'bar','x','GRÁFICO VERTICAL DESPLAZAMIENTOS','myChart1_param');
        }   
    })
}

// Grafico Pastel  Desplazamientos
function getGraficoParams2() {
    let anio = $("#select-anio").val();

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/controller_param.php',
        type: 'POST',
        data:{
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
            CreateGrafico(equipo, cantidad, colors,'pie','','GRÁFICO PASTEL DE EQUIPOS','myChart2_param');
        }   
    })
}

// Grafico doughnut Desplazamientos
function getGraficoParams3() {
    let anio = $("#select-anio").val();

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/controller_param.php',
        type: 'POST',
        data:{
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
            CreateGrafico(equipo, cantidad, colors,'doughnut','','GRÁFICO DOUGHNUT DESPLAZAMIENTOS','myChart3_param');
        }   
    })
}

// Grafico bar Horizontal Desplazamientos
function getGraficoParams4() {
    let anio = $("#select-anio").val();

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/graficos/controller_param.php',
        type: 'POST',
        data:{
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
            CreateGrafico(equipo, cantidad, colors,'bar','y','GRÁFICO HORIZONTAL DESPLAZAMIENTOS','myChart4_param');
        }   
    })
}
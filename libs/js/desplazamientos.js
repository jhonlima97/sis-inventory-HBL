$(document).ready(function () {
    //listar_asignaciones();
    getTabla2();
});

var tbl_desplazamientos;

var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ Registros por página",
    "sZeroRecords": "No se encontraron resultados",
    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
    "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ Registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "oPaginate": {
        "sFirst": "Primero",
        "sPrevious": "Anterior",
        "sNext": "Siguiente",
        "sLast": "Último"
    }
};

function listar_asignaciones() {

    if (typeof tbl_desplazamientos === 'undefined' || tbl_desplazamientos === null) {
        tbl_desplazamientos = $("#tbl_desplazamientos").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": true },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "pageLength": 5,
            "destroy": true,
            "async": false,
            "processing": false,
           
            "columns": [
                //{ "defaultContent": "" },
                { "data" : "id"},
                { "data": "motivo" },
                { "data": "nom_area_prov" },
                { "data": "responsable_prov"},
                { "data": "nom_area_asig" },
                { "data": "responsable_asig"},
                { "data": "fecha" },
                //{ "data": "codigos_patrimoniales", "searchable": true }, // Habilita la búsqueda para esta columna
                { "data": "codigos_patrimoniales" }, // , "visible": false Habilita la búsqueda para esta columna
                {   // Agregar el botón en la columna "Equipos"
                    "data": null,
                    render: function (data, type, row) {
                        return  '<button class="ver_detalle btn btn-secondary btn-xs" ><i class="fas fa-search"></i></button>';
                    },
                    className: 'text-center' 
                },
                {
                    "data": null,
                    render: function (data, type, row) {
                        return '<button class="editar_fecha btn btn-warning btn-xs"><i class="fas fa-calendar"></i></button>'+ '   ' +
                        '<button class="imprimir btn btn-primary btn-xs" onclick="Imprimir_reporte(\'' + row.id + '\')"><i class="fas fa-print"></i></button>';
                    },
                    className: 'text-center'                 
                }
            ],
            "columnDefs": [
                {
                    // "className": "text-center",
                    //"targets": [0],  // Índice de la columna de ID del Datatable
                    //"visible": true,
                    
                }
            ],
            "language": idioma_espanol,
            select: true,
        });

    }

}

function getTabla2() {
    if (!tbl_desplazamientos) {
        tbl_desplazamientos = $("#tbl_desplazamientos").DataTable(listar_asignaciones());
    } else {
        tbl_desplazamientos.clear().draw(); // Limpia los datos existentes
    }

    // Actualiza la URL AJAX para cargar los nuevos datos
    tbl_desplazamientos.ajax.url("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/reportes/listar_desplazamientos.php").load();

    // Lógica para numerar las filas
    var PageInfo = tbl_desplazamientos.page.info();
    tbl_desplazamientos.column(0, { page: 'current' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });

    // Redibujar la tabla después de la numeración
    tbl_desplazamientos.draw();
}


function Imprimir_reporte(id){
    window.open("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/views/fpdf/rptDesplazamiento.php?cod_rpt="+id, "_blank");
}

function ver_detalle_desp(id){
    window.location.href = "https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/views/index.php?view=detalle_desplazamientos&cod_desp=" + id;
}



$('#tbl_desplazamientos').on('click', '.editar_fecha', function () {
    var data = tbl_desplazamientos.row($(this).parents('tr')).data();

    if (tbl_desplazamientos.row(this).child.isShown()) {
        var data = tbl_desplazamientos.row(this).data;
       
    }
   
    //Abrir Modal para editar computadoras 
    $("#modal_reporte_fecha").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_reporte_fecha").modal('show');

    document.getElementById('txt_cod_actualizar').value  = data.id; 
    document.getElementById('fecha_actualizar').value = data.fecha;

})


function Editar_fecha_reporte(){
    let fecha = document.getElementById('fecha_actualizar').value;
    let id_desplazamiento = document.getElementById('txt_cod_actualizar').value;

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/reportes/actualizar_fecha.php',
        type: 'POST',
        data: {
            id: id_desplazamiento,
            fecha: fecha
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Fecha actualizada", "success")
                .then((value) => {
                    $("#modal_reporte_fecha").modal('hide');
                    tbl_desplazamientos.ajax.reload();
                });
        }  else {
            Swal.fire("Mensaje de Error", "No se pudo actualizar los datos", "error");
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      
        Swal.fire('Error', 'Ocurrió un problema al procesar la solicitud', 'error');
    }); 
}

/*$("#modal_visualizar_detalle").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
$('.form-control').removeClass("is-invalid").removeClass("is-valid")
$("#modal_visualizar_detalle").modal('show');*/


$('#tbl_desplazamientos').on('click', '.ver_detalle', function () {
    var data = tbl_desplazamientos.row($(this).parents('tr')).data();

    if (tbl_desplazamientos.row(this).child.isShown()) {
        var data = tbl_desplazamientos.row(this).data;
       
    }
   
    //Abrir Modal para editar computadoras 
    $("#modal_visualizar_detalle").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_visualizar_detalle").modal('show');


    var codigo = data.id;

    obtenerDatosServidor(codigo)


    //var cod_desp =  data.id; 
    //document.getElementById('fecha_actualizar').value = data.fecha;

})

function llenarTabla(respuesta) {
    var datos = respuesta.data; // Accedemos a la clave "data" de la respuesta
    var tabla = document.getElementById("tbl_detalle");
    // Limpiar la tabla antes de agregar nuevos datos
    tabla.innerHTML = "";

    // Crear el encabezado de la tabla
    var encabezado = tabla.createTHead();
    var filaEncabezado = encabezado.insertRow();

    filaEncabezado.insertCell().textContent = "ID Desplazamiento";
    filaEncabezado.insertCell().textContent = "Tipo de bien";
    filaEncabezado.insertCell().textContent = "Código Patrimonial";
    filaEncabezado.insertCell().textContent = "Marca";
    filaEncabezado.insertCell().textContent = "Modelo";
    filaEncabezado.insertCell().textContent = "Serie";

    // Crear el cuerpo de la tabla
    var cuerpoTabla = tabla.createTBody();
    datos.forEach(function (fila) {
        var filaTabla = cuerpoTabla.insertRow();
        filaTabla.insertCell().textContent = fila.id_desplazamiento;
        filaTabla.insertCell().textContent = fila.tipo_bien;
        filaTabla.insertCell().textContent = fila.cod_patrimonial;
        filaTabla.insertCell().textContent = fila.marca;
        filaTabla.insertCell().textContent = fila.modelo || "Sin Modelo";
        filaTabla.insertCell().textContent = fila.serie || "Sin Serie";
    });
}

// Función para realizar la solicitud AJAX y obtener los datos del servidor

function obtenerDatosServidor(cod_Desp) {
    var url = "https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/reportes/listar_detalle.php";

    var cod_desp = cod_Desp;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                
                
                var datos = JSON.parse(xhr.responseText); // Convertir la respuesta JSON en un objeto JavaScript
                
                llenarTabla(datos); // Llamar a la función para llenar la tabla con los datos recibidos
            } else {
                console.error("Error al realizar la solicitud AJAX:", xhr.status);
            }
        }
    };
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("cod_desp=" + encodeURIComponent(cod_desp));
}



// Llamar a la función para obtener los datos del servidor cuando el documento esté listo
//document.addEventListener("DOMContentLoaded", obtenerDatosServidor);


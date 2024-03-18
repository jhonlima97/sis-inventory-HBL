$(document).ready(function () {
    CargarSelectAreas();
    CargarSelectAreas_Edit();
});

var tbl_computadoras;

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

// Funcion Listar computadoras desde la BD
function listar_computadoras() {
    if (typeof tbl_computadoras === 'undefined' || tbl_computadoras === null) {
        tbl_computadoras = $("#tbl_computadoras").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": true },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            // "pageLength": 10,
            "destroy": true,
            "async": false,
            "processing": false,
            "ajax": {
                "url": "../controllers/equipos/listar_computadoras.php",
                type: 'POST'
            },
            "columns": [
                { "defaultContent": "" },
                { "data": "cod_patrimonial" },
                { "data": "marca" },
                { 
                    "data": "modelo",
                    "render": function (data, type, row) {
                        if (data === null || data === "") {
                            return '<em>Sin Modelo</em>';
                        } else {
                            return data;
                        }
                    }
                },
                { 
                    "data": "serie",
                    "render": function (data, type, row) {
                        if (data === null || data === "") {
                            return '<em>Sin Serie</em>';
                        } else {
                            return data;
                        }
                    }
                },
                { "data": "sis_ope" },
                { 
                    "data": "ip",
                    "render": function (data, type, row) {
                        if (data === null || data === "") {
                            return '<em>Sin IP</em>';
                        } else {
                            return data;
                        }
                    }
                 },
                { "data": "procesador" },
                { "data": "ram" },
                { 
                    "data": "disco",
                    "render": function (data, type, row) {
                        if (data === null || data === "") {
                            return '<em>Sin Disco</em>';
                        } else {
                            return data;
                        }
                    }
                },
                { "data": "nombre_area" },
                {
                    "data": "estado",
                    render: function (data, type, row) {
                        if (data == 'BUENO') {
                            return '<span class="badge bg-success">BUENO</span>'
                        } else {
                            return '<span class="badge bg-danger">MALO</span>'
                        }
                    }
                },
                {
                    "data": null,
                    
                    "render": function (data, type, row) {
                        return "<button class='editar btn btn-primary btn-sm' title='Editar'><i class='fas fa-edit'></i></button>" +
                               "<button class='eliminar btn btn-danger btn-sm' title='Eliminar' " +
                               "onclick='Eliminar_Computadora(\"" + row.cod_patrimonial + "\")'><i class='fas fa-trash'></i></button>";
                    }                   
                }
            ],
            "columnDefs": [
                {
                    "targets": [0],  // Índice de la columna de ID del Datatable
                    "visible": false,
                }
            ],
            "language": idioma_espanol,
            select: true
        });

        tbl_computadoras.on('draw.td', function () {
            var PageInfo = $("#tbl_computadoras").DataTable().page.info();
            tbl_computadoras.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }
}

// Funcion Listar el nombre de las areas desde la BD
function CargarSelectAreas() {
    $("#select_area").load("../controllers/equipos/CargarSelectAreas.php");
}

function CargarSelectAreas_Edit() {
    $("#select_area_editar").load("../controllers/equipos/CargarSelectAreas.php");
}

// Para el modal de registro
$("#modal_registro_computadora .select2-dropdown").select2({
    dropdownParent: $('#modal_registro_computadora')
});

function AbrirModalRegistroComputadora() {
    //LimpiarModalComputadoras();
    $("#modal_registro_computadora").modal({ backdrop: 'static', keyboard: false }) 
    $("#modal_registro_computadora").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function Registrar_Computadora() {
    let codigo  = document.getElementById('txt_cod').value;
    let marca   = document.getElementById('select_marca').value;
    let modelo  = document.getElementById('txt_modelo').value;
    let serie   = document.getElementById('txt_serie').value;
    let so      = document.getElementById('txt_so').value;
    let ip      = document.getElementById('txt_ip').value;
    let procesador = document.getElementById('txt_procesador').value;
    let ram        = document.getElementById('select_ram').value;
    let disco   = document.getElementById('txt_disco').value;
    let area    = document.getElementById('select_area').value;
    let estado  = document.getElementById('select_estado').value;

    $.ajax({
        url: '../controllers/equipos/registrar_computadora.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            marca: marca,
            modelo: modelo,
            serie: serie,
            sis_ope: so,
            ip: ip,
            procesador: procesador,
            ram: ram,
            disco: disco,
            area_id: area,
            estado: estado
        }
    }).done(function (resp) {
        console.log("Respuesta del servidor:", resp);
    
        if (resp.status === "Success") {
            Swal.fire("Mensaje de Confirmación", "Computadora Registrada", "success")
                .then((value) => {
                    $("#modal_registro_computadora").modal('hide');
                    tbl_computadoras.ajax.reload();
                });
            // Aquí puedes realizar otras acciones después de un registro exitoso
        } else if (resp.status === "Codigo existente") {
            Swal.fire({
                title: "Código Existente",
                html: "El código: <b>" + codigo + "</b> ya existe.",
                icon: "warning"
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error al registrar la computadora",
                icon: "error"
            });
        }
    })
}

// Para el modal de edición
$("#modal_editar_computadora .select2-dropdown").select2({
    dropdownParent: $('#modal_editar_computadora')
});

// Abrir el modal de Modificar y cargar los datos de acuerdo a cada computadora
$('#tbl_computadoras').on('click', '.editar', function () {
    var data = tbl_computadoras.row($(this).parents('tr')).data();

    if (tbl_computadoras.row(this).child.isShown()) {
        var data = tbl_computadoras.row(this).data;
    }
    //alert(data);
    //Abrir Modal para editar computadoras 
    $("#modal_editar_computadora").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_computadora").modal('show');

    document.getElementById('txt_cod_editar').value  = data.cod_patrimonial;
    document.getElementById('txt_modelo_editar').value = data.modelo;
    document.getElementById('txt_serie_editar').value = data.serie;
    document.getElementById('txt_so_editar').value = data.sis_ope;
    document.getElementById('txt_ip_editar').value = data.ip;
    document.getElementById('txt_procesador_editar').value = data.procesador;
    document.getElementById('txt_disco_editar').value = data.disco;
    // Cargar los valores seleccionados
    $("#select_ram_editar").val(data.ram).trigger('change');        //select ram
    $("#select_marca_editar").val(data.marca).trigger('change');    //select marca
    $("#select_area_editar").val(data.area_id).trigger('change');   //select area

    document.getElementById('select_estado_editar').value = data.estado;
})

// Funcion Modificar computadoras en la BD
function Modificar_Computadora() {
    let codigo = document.getElementById('txt_cod_editar').value;
    let marca = document.getElementById('select_marca_editar').value;
    let modelo = document.getElementById('txt_modelo_editar').value;
    let serie = document.getElementById('txt_serie_editar').value;
    let so = document.getElementById('txt_so_editar').value;
    let ip = document.getElementById('txt_ip_editar').value;
    let procesador = document.getElementById('txt_procesador_editar').value;
    let ram = document.getElementById('select_ram_editar').value;
    let disco = document.getElementById('txt_disco_editar').value;
    let area = document.getElementById('select_area_editar').value;
    let estado = document.getElementById('select_estado_editar').value;

    // if (responsable.length === 0 || nombre.length === 0 || id.length === 0) {
    //     return Swal.fire("Mensaje de Advertencia", "Tiene algunos campos vacíos", "warning");
    // }
    console.log("Cod_Patrimonial: ", codigo);
    console.log("Nueva Serie: ", serie);
    $.ajax({
        url: '../controllers/equipos/modificar_computadora.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            marca: marca,
            modelo: modelo,
            serie: serie,
            sis_ope: so,
            ip: ip,
            procesador: procesador,
            ram: ram,
            disco: disco,
            area_id: area,
            estado: estado
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Computadora actualizada", "success")
                .then((value) => {
                    $("#modal_editar_computadora").modal('hide');
                    tbl_computadoras.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "Ya existe un computadora con esa SERIE", "warning");
        } else {
            Swal.fire("Mensaje de Error", "No se pudo actualizar los datos", "error");
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al procesar la solicitud:', textStatus, errorThrown);
        // Muestra la respuesta recibida desde el servidor en caso de un error
        console.log(jqXHR.responseText);
        Swal.fire('Error', 'Ocurrió un problema al procesar la solicitud', 'error');
    });    
    
}

// Funcion Eliminar Computadoras en la BD
function Eliminar_Computadora(cod_patrimonial) {
    // Puedes mostrar un diálogo de confirmación antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la computadora. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamada AJAX para eliminar la compu
            console.log(cod_patrimonial)
            $.ajax({
                url: '../controllers/equipos/eliminar_computadora.php',
                type: 'POST',
                data: {
                    cod_patrimonial: cod_patrimonial
                },
                dataType: 'json' // Asegúrate de esperar un JSON como respuesta
            }).done(function (resp) {
                console.log(resp);
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'Computadora Eliminada', 'success').then(() => {
                        //Actualizar la tabla
                        tbl_computadoras.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la computadora', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar la computadora', 'error');
            });
        }
    });
}

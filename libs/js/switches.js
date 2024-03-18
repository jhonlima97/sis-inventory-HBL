$(document).ready(function () {
    CargarSelectAreas();
    CargarSelectAreas_Edit();
});

var tbl_switches;

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

// Funcion Listar switches desde la BD
function listar_switches() {
    if (typeof tbl_switches === 'undefined' || tbl_switches === null) {
        tbl_switches = $("#tbl_switches").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": false },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            // "pageLength": 10,
            "destroy": true,
            "async": false,
            "processing": false,
            "ajax": {
                "url": "https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/listar_switches.php",
                type: 'POST'
            },
            "columns": [
                { "defaultContent": "" },  
                { "data": "cod_patrimonial" },
                { "data": "nombre" },
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
                { "data": "puertos" },
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
                    // Si deseas cambiar el tamaño de los iconos, puedes utilizar las siguientes clases:
                    // btn-xs (pequeño)
                    // btn-sm (mediano)
                    // btn-lg (grande)
                    // btn-xl (extra grande)
                    render: function (data, type, row) {
                        return '<button class="editar btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit"></i></button>' +
                               '<button class="eliminar btn btn-danger btn-sm" title="Eliminar" ' +
                               'onclick="Eliminar_Switch(\'' + row.cod_patrimonial + '\')"><i class="fas fa-trash"></i></button>';
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

        tbl_switches.on('draw.td', function () {
            var PageInfo = $("#tbl_switches").DataTable().page.info();
            tbl_switches.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }
}

// Funcion Listar el nombre de las areas desde la BD
function CargarSelectAreas() {
    $("#select_area").load("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/CargarSelectAreas.php");
}

function CargarSelectAreas_Edit() {
    $("#select_area_editar").load("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/CargarSelectAreas.php");
}

// Para el modal de registro
$("#modal_registro_switch .select2-dropdown").select2({
    dropdownParent: $('#modal_registro_switch')
});

function AbrirModalRegistroSwitch() {
    //LimpiarModalComputadoras();
    $("#modal_registro_switch").modal({ backdrop: 'static', keyboard: false }) 
    $("#modal_registro_switch").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function Registrar_Switch() {
    let codigo  = document.getElementById('txt_cod').value;
    let nombre  = document.getElementById('txt_nombre').value;
    let marca   = document.getElementById('select_marca').value;
    let modelo  = document.getElementById('txt_modelo').value;
    let serie   = document.getElementById('txt_serie').value;
    let puerto  = document.getElementById('txt_puerto').value;
    let area    = document.getElementById('select_area').value;
    let estado  = document.getElementById('select_estado').value;

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/registrar_switch.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            nombre: nombre,
            marca: marca,
            modelo: modelo,
            serie: serie,
            puertos: puerto,
            area_id: area,
            estado: estado
        }
    }).done(function (resp) {
        console.log("Respuesta del servidor:", resp);
    
        if (resp.status === "Success") {
            Swal.fire("Mensaje de Confirmación", "Switch Registrado", "success")
                .then((value) => {
                    $("#modal_registro_switch").modal('hide');
                    tbl_switches.ajax.reload();
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
                text: "Ocurrió un error al registrar el switch",
                icon: "error"
            });
        }
    })
}

// Para el modal de edición
$("#modal_editar_switch .select2-dropdown").select2({
    dropdownParent: $('#modal_editar_switch')
});

$('#tbl_switches').on('click', '.editar', function () {
    var data = tbl_switches.row($(this).parents('tr')).data();

    if (tbl_switches.row(this).child.isShown()) {
        var data = tbl_switches.row(this).data;
       
    }
    //alert(data);
    //Abrir Modal para editar switchs 
    $("#modal_editar_switch").modal({ backdrop: 'static', keyboard: false }) 
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_switch").modal('show');

    document.getElementById('txt_cod_editar').value  = data.cod_patrimonial; 
    document.getElementById('txt_nombre_editar').value = data.nombre;
    document.getElementById('txt_modelo_editar').value = data.modelo;
    document.getElementById('txt_serie_editar').value = data.serie;
    document.getElementById('txt_puerto_editar').value = data.puertos;

    $("#select_marca_editar").val(data.marca).trigger('change');  
    $("#select_area_editar").val(data.area_id).trigger('change');  
    document.getElementById('select_estado_editar').value = data.estado

})

function Modificar_Switch() {
    let codigo = document.getElementById('txt_cod_editar').value;
    let nombre = document.getElementById('txt_nombre_editar').value;
    let marca = document.getElementById('select_marca_editar').value;
    let modelo = document.getElementById('txt_modelo_editar').value;
    let serie = document.getElementById('txt_serie_editar').value;
    let puerto = document.getElementById('txt_puerto_editar').value;
    let area = document.getElementById('select_area_editar').value;
    let estado = document.getElementById('select_estado_editar').value;

    console.log("Cod_Patrimonial: ", codigo);
    console.log("Nueva Serie: ", serie);

    $.ajax({
        url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/modificar_switch.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            nombre: nombre,
            marca: marca,
            modelo: modelo,
            serie: serie,
            puertos: puerto,
            area_id: area,
            estado: estado
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Switch actualizado", "success")
                .then((value) => {
                    $("#modal_editar_switch").modal('hide');
                    tbl_switches.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "Ya existe un switch con esa serie", "warning");
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



function Eliminar_Switch(cod_patrimonial) {
    // Puedes mostrar un diálogo de confirmación antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el switch. ¿Deseas continuar?',
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
                url: 'https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/equipos/eliminar_switch.php',
                type: 'POST',
                data: {
                    cod_patrimonial: cod_patrimonial
                },
                dataType: 'json'
            }).done(function (resp) {
                console.log(resp);
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'Switch Eliminado', 'success').then(() => {
                        //Actualizar la tabla
                        tbl_switches.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el switch', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar el switch', 'error');
            });
        }
    });
}



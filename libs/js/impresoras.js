$(document).ready(function () {
    CargarSelectAreas();
    CargarSelectAreas_Edit();
});

var tbl_impresoras;

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

// Funcion Listar impresoras desde la BD
function listar_impresoras() {
    if (typeof tbl_impresoras === 'undefined' || tbl_impresoras === null) {
        tbl_impresoras = $("#tbl_impresoras").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": false },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            // "pageLength": 10,
            "destroy": true,
            "async": false,
            "processing": false,
            "ajax": {
                "url": "../controllers/equipos/listar_impresoras.php",
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
                { 
                    "data": "num_toner",
                    "render": function (data, type, row) {
                        if (data === null || data === "") {
                            return '<em>Sin toner</em>';
                        } else {
                            return data;
                        }
                    }
                },
                { "data": "area" },
                {
                    "data": "estado",
                    render: function (data, type, row) {
                        if (data == 'BUENO') {
                            return '<span class="badge bg-success">BUENO</span>'
                        } else if (data == 'REGULAR'){
                            return '<span class="badge bg-warning">REGULAR</span>'
                        } else{
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
                               'onclick="Eliminar_Impresora(\'' + row.cod_patrimonial + '\')"><i class="fas fa-trash"></i></button>';
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

        tbl_impresoras.on('draw.td', function () {
            var PageInfo = $("#tbl_impresoras").DataTable().page.info();
            tbl_impresoras.column(0, { page: 'current' }).nodes().each(function (cell, i) {
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
$("#modal_registro_impresora .select2-dropdown").select2({
    dropdownParent: $('#modal_registro_impresora')
});

function AbrirModalRegistroImpresora() {
    //LimpiarModalComputadoras();
    $("#modal_registro_impresora").modal({ backdrop: 'static', keyboard: false }) 
    $("#modal_registro_impresora").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function Registrar_Impresora() {
    let codigo  = document.getElementById('txt_cod').value;
    let marca   = document.getElementById('select_marca').value;
    let modelo  = document.getElementById('txt_modelo').value;
    let serie   = document.getElementById('txt_serie').value;
    let num_toner = document.getElementById('txt_toner').value;
    let estado  = document.getElementById('select_estado').value;
    let area    = document.getElementById('select_area').value;
    // $("#select_area").select2().val(data.area).trigger('change.select2');

$.ajax({
    url: '../controllers/equipos/registrar_impresora.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            marca: marca,
            modelo: modelo,
            serie: serie,
            num_toner: num_toner,
            estado: estado,
            area_id: area
        }
}).done(function (resp){
    console.log("Respuesta del servidor", resp);
    if (resp.status === "Success") {
        Swal.fire("Mensaje de Confirmación", "Impresora Registrada", "success")
            .then((value) => {
                $("#modal_registro_impresora").modal('hide');
                tbl_impresoras.ajax.reload();
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
            text: "Ocurrió un error al registrar la impresora",
            icon: "error"
        });
    }
})
}

// Para el modal de edición
$("#modal_editar_impresora .select2-dropdown").select2({
    dropdownParent: $('#modal_editar_impresora')
});

$('#tbl_impresoras').on('click', '.editar', function () {
    var data = tbl_impresoras.row($(this).parents('tr')).data();
    if (tbl_impresoras.row(this).child.isShown()) {
        var data = tbl_impresoras.row(this).data;
    }
    $("#modal_editar_impresora").modal({ backdrop: 'static', keyboard: false }) //No cerrar al dar click al costado
    $("#modal_editar_impresora").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")

    document.getElementById('txt_cod_editar').value = data.cod_patrimonial;
    document.getElementById('txt_modelo_editar').value = data.modelo;
    document.getElementById('txt_serie_editar').value = data.serie;
    document.getElementById('txt_toner_editar').value = data.num_toner;
    // Cargar los valores seleccionados
    $("#select_marca_editar").val(data.marca).trigger('change');
    $("#select_area_editar").val(data.area_id).trigger('change');

    document.getElementById('select_estado_editar').value   = data.estado;

});


function Modificar_Impresora() {
    let codigo = document.getElementById('txt_cod_editar').value;
    let marca = document.getElementById('select_marca_editar').value;
    let modelo = document.getElementById('txt_modelo_editar').value;
    let serie = document.getElementById('txt_serie_editar').value;
    let num_toner = document.getElementById('txt_toner_editar').value;
    let estado = document.getElementById('select_estado_editar').value;
    let area = document.getElementById('select_area_editar').value;

    // if (responsable.length === 0 || nombre.length === 0 || id.length === 0) {
    //     return Swal.fire("Mensaje de Advertencia", "Tiene algunos campos vacíos", "warning");
    // }
    console.log("Cod_Patrimonial: ", codigo);
    console.log("Nueva Serie: ", serie);
    $.ajax({
        url: '../controllers/equipos/modificar_impresora.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            marca: marca,
            modelo: modelo,
            serie: serie,
            num_toner: num_toner,
            estado: estado,
            area_id: area
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Impresora actualizada", "success")
                .then((value) => {
                    $("#modal_editar_impresora").modal('hide');
                    tbl_impresoras.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "Ya existe una impresora con esa serie", "warning");
        } else {
            Swal.fire("Mensaje de Error", "No se pudo actualizar los datos", "error");
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error al procesar la solicitud:', textStatus, errorThrown);
        
        console.log(jqXHR.responseText);
        Swal.fire('Error', 'Ocurrió un problema al procesar la solicitud', 'error');
    });    
    
}

function Eliminar_Impresora(cod_patrimonial) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la impresoras. ¿Deseas continuar?',
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
                url: '../controllers/equipos/eliminar_impresora.php',
                type: 'POST',
                data: {
                    cod_patrimonial: cod_patrimonial
                },
                dataType: 'json' // Asegúrate de esperar un JSON como respuesta
            }).done(function (resp) {
                console.log(resp);
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'Impresora Eliminada', 'success').then(() => {
                        //Actualizar la tabla
                        tbl_impresoras.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la impresora', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar la impresora', 'error');
            });
        }
    });
}



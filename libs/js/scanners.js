$(document).ready(function () {
    CargarSelectAreas();
    CargarSelectAreas_Edit();
    listar_scanners();
});

var tbl_scanners;

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

function listar_scanners() {
    if (typeof tbl_scanners === 'undefined' || tbl_scanners === null) {
        tbl_scanners = $("#tbl_scanners").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": true },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            // "pageLength": 10,
            "destroy": true,
            "async": false,
            "processing": false,
            "ajax": {
                "url": "../controllers/equipos/listar_scanners.php",
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
                { "data": "sistema_operativo" },
                { "data": "velocidad" },
                { "data": "resolucion" },
                
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
                    render: function (data, type, row) {
                        return '<button class="editar btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit"></i></button>' +
                               '<button class="eliminar btn btn-danger btn-sm" title="Eliminar" ' +
                               'onclick="Eliminar_Scanner(\'' + row.cod_patrimonial + '\')"><i class="fas fa-trash"></i></button>';
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

        tbl_scanners.on('draw.td', function () {
            var PageInfo = $("#tbl_scanners").DataTable().page.info();
            tbl_scanners.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }
}

function CargarSelectAreas() {
    $("#select_area").load("../controllers/equipos/CargarSelectAreas.php");
}
function CargarSelectAreas_Edit() {
    $("#select_area_editar").load("../controllers/equipos/CargarSelectAreas.php");
}

function AbrirModalRegistroScanner() {
    //LimpiarModalComputadoras();
    $("#modal_registro_scanner").modal({ backdrop: 'static', keyboard: false }) 
    $("#modal_registro_scanner").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function Registrar_Scanner() {
    let cod       = document.getElementById('txt_cod').value;
    let marca     = document.getElementById('select_marca').value;
    let modelo    = document.getElementById('txt_modelo').value;
    let serie     = document.getElementById('txt_serie').value;
    let so        = document.getElementById('txt_sis_ope').value;
    let velocidad = document.getElementById('txt_velocidad').value;
    let resol     = document.getElementById('txt_resolucion').value;
    let area    = document.getElementById('select_area').value;
    let estado  = document.getElementById('select_estado').value;

    $.ajax({
        url: '../controllers/equipos/registrar_scanner.php',
        type: 'POST',
        data: {
            cod_patrimonial: cod,
            marca: marca,
            modelo: modelo,
            serie: serie,
            sistema_operativo: so,
            velocidad: velocidad,
            resolucion: resol,
            area_id: area,
            estado: estado
        }
    }).done(function (resp) {
        console.log("Respuesta del servidor:", resp);
    
        if (resp.status === "Success") {
            Swal.fire("Mensaje de Confirmación", "Scanner registrado", "success")
                .then((value) => {
                    $("#modal_registro_scanner").modal('hide');
                    tbl_scanners.ajax.reload();
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
                text: "Ocurrió un error al registrar el producto",
                icon: "error"
            });
        }
    })
}

$('#tbl_scanners').on('click', '.editar', function () {
    var data = tbl_scanners.row($(this).parents('tr')).data();

    if (tbl_scanners.row(this).child.isShown()) {
        var data = tbl_scanners.row(this).data;
       
    }
    //alert(data);
    //Abrir Modal para editar scanners 
    $("#modal_editar_scanner").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_scanner").modal('show');

    document.getElementById('txt_cod_editar').value  = data.cod_patrimonial; //Nombre de tabla segun listar
    $("#select_marca_editar").select2().val(data.marca).trigger('change.select2');  //select marca bien
    document.getElementById('txt_modelo_editar').value = data.modelo;
    document.getElementById('txt_serie_editar').value = data.serie;
    document.getElementById('txt_so_editar').value = data.sistema_operativo;
    document.getElementById('txt_velocidad_editar').value = data.velocidad;
    document.getElementById('txt_resol_editar').value = data.resolucion;
    $("#select_area_editar").select2().val(data.area_id).trigger('change.select2');   //select area
    $("#select_estado_editar").select2().val(data.estado).trigger('change.select2');  //select estado

})

function Modificar_Scanner() {
    let cod        = document.getElementById('txt_cod_editar').value;
    let marca      = document.getElementById('select_marca_editar').value;
    let modelo     = document.getElementById('txt_modelo_editar').value;
    let serie      = document.getElementById('txt_serie_editar').value;
    let so         = document.getElementById('txt_so_editar').value;
    let velocidad  = document.getElementById('txt_velocidad_editar').value;
    let resol      = document.getElementById('txt_resol_editar').value;
    let area       = document.getElementById('select_area_editar').value;
    let estado     = document.getElementById('select_estado_editar').value;

    // if (responsable.length === 0 || nombre.length === 0 || id.length === 0) {
    //     return Swal.fire("Mensaje de Advertencia", "Tiene algunos campos vacíos", "warning");
    // }
    console.log("Cod_Patrimonial: ", cod);
    console.log("Nueva Serie: ", serie);
    $.ajax({
        url: '../controllers/equipos/modificar_scanner.php',
        type: 'POST',
        data: {
            cod_patrimonial: cod,
            marca: marca,
            modelo: modelo,
            serie: serie,
            sistema_operativo: so,
            velocidad: velocidad,
            resolucion: resol,
            area_id: area,
            estado: estado
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Producto actualizado", "success")
                .then((value) => {
                    $("#modal_editar_scanner").modal('hide');
                    tbl_scanners.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "Ya existe un scanner con esa SERIE", "warning");
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

function Eliminar_Scanner(cod_patrimonial) {
    // Puedes mostrar un diálogo de confirmación antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el producto. ¿Deseas continuar?',
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
                url: '../controllers/equipos/eliminar_scanner.php',
                type: 'POST',
                data: {
                    cod_patrimonial: cod_patrimonial
                },
                dataType: 'json' // Asegúrate de esperar un JSON como respuesta
            }).done(function (resp) {
                console.log(resp);
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'Producto eliminado', 'success').then(() => {
                        //Actualizar la tabla
                        tbl_scanners.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el producto', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar el producto', 'error');
            });
        }
    });
}


$(document).ready(function () {
    CargarSelectAreas();
    CargarSelectAreas_Edit();
});

var tbl_servidores;

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

// Funcion Listar servidores desde la BD
function listar_servidores() {
    if (typeof tbl_servidores === 'undefined' || tbl_servidores === null) {
        tbl_servidores = $("#tbl_servidores").DataTable({
            "ordering": false,
            "bLengthChange": true,
            "searching": { "regex": false },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            // "pageLength": 10,
            "destroy": true,
            "async": false,
            "processing": false,
            "ajax": {
                "url": "../controllers/equipos/listar_servidores.php",
                type: 'POST'
            },
            // Negrita  <b>, <strong>
            //Oblicua  <em>
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
                    // Si deseas cambiar el tamaño de los iconos, puedes utilizar las siguientes clases:
                    // btn-xs (pequeño)
                    // btn-sm (mediano)
                    // btn-lg (grande)
                    // btn-xl (extra grande)

                    render: function (data, type, row) {
                        return '<button class="editar btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit"></i></button>' +
                               '<button class="eliminar btn btn-danger btn-sm" title="Eliminar" ' +
                               'onclick="Eliminar_Servidor(\'' + row.cod_patrimonial + '\')"><i class="fas fa-trash"></i></button>';
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

        tbl_servidores.on('draw.td', function () {
            var PageInfo = $("#tbl_servidores").DataTable().page.info();
            tbl_servidores.column(0, { page: 'current' }).nodes().each(function (cell, i) {
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

function AbrirModalRegistroServidor() {
    //LimpiarModalComputadoras();
    $("#modal_registro_servidor").modal({ backdrop: 'static', keyboard: false }) 
    $("#modal_registro_servidor").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function Registrar_Servidor() {
    let codigo  = document.getElementById('txt_cod').value;
    let nombre  = document.getElementById('txt_nombre').value;
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
        url: '../controllers/equipos/registrar_servidor.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            nombre: nombre,
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
            Swal.fire("Mensaje de Confirmación", "Servidor Registrado", "success")
                .then((value) => {
                    $("#modal_registro_servidor").modal('hide');
                    tbl_servidores.ajax.reload();
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
                text: "Ocurrió un error al registrar el servidor",
                icon: "error"
            });
        }
    })
}

$('#tbl_servidores').on('click', '.editar', function () {
    var data = tbl_servidores.row($(this).parents('tr')).data();

    if (tbl_servidores.row(this).child.isShown()) {
        var data = tbl_servidores.row(this).data;
       
    }
    //alert(data);
    //Abrir Modal para editar servidores 
    $("#modal_editar_servidor").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_servidor").modal('show');

    document.getElementById('txt_cod_editar').value  = data.cod_patrimonial;
    document.getElementById('txt_nombre_editar').value  = data.nombre;
    $("#select_marca_editar").select2().val(data.marca).trigger('change.select2');  //select marca bien
    document.getElementById('txt_modelo_editar').value = data.modelo;
    document.getElementById('txt_serie_editar').value = data.serie;
    document.getElementById('txt_so_editar').value = data.sis_ope;
    document.getElementById('txt_ip_editar').value = data.ip;
    document.getElementById('txt_procesador_editar').value = data.procesador;
    $("#select_ram_editar").select2().val(data.ram).trigger('change.select2');  //select ram  bien
    document.getElementById('txt_disco_editar').value = data.disco;
    $("#select_area_editar").select2().val(data.area_id).trigger('change.select2');   //select area
    $("#select_estado_editar").select2().val(data.estado).trigger('change.select2');  //select estado

})

function Modificar_Servidor() {
    let codigo = document.getElementById('txt_cod_editar').value;
    let nombre = document.getElementById('txt_nombre_editar').value;
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
        url: '../controllers/equipos/modificar_servidor.php',
        type: 'POST',
        data: {
            cod_patrimonial: codigo,
            nombre: nombre,
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
            Swal.fire("Mensaje de Confirmación", "Servidor actualizado", "success")
                .then((value) => {
                    $("#modal_editar_servidor").modal('hide');
                    tbl_servidores.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "Ya existe un servidor con esa SERIE", "warning");
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

function Eliminar_Servidor(cod_patrimonial) {
    // Puedes mostrar un diálogo de confirmación antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el servidor. ¿Deseas continuar?',
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
                url: '../controllers/equipos/eliminar_servidor.php',
                type: 'POST',
                data: {
                    cod_patrimonial: cod_patrimonial
                },
                dataType: 'json' // Asegúrate de esperar un JSON como respuesta
            }).done(function (resp) {
                console.log(resp);
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'Servidor eliminado', 'success').then(() => {
                        //Actualizar la tabla
                        tbl_servidores.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el servidor', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar el servidor', 'error');
            });
        }
    });
}






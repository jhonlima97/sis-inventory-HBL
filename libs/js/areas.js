var tbl_areas;
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
    // Puedes agregar más configuraciones según tus necesidades
};

// Funcion Listar areas desde la BD
function listar_areas() {
    tbl_areas = $("#tbl_area").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        // "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controllers/areas/listar_area.php",
            type: 'POST'
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "nombre" },
            { "data": "responsable" },
            {
                "data": null,
                // Si deseas cambiar el tamaño de los iconos, puedes utilizar las siguientes clases:
                // btn-xs (pequeño)
                // btn-sm (mediano)
                // btn-lg (grande)
                // btn-xl (extra grande)

                render: function (data, type, row) {
                    return "<button class='editar btn btn-primary btn-sm'><i class='fas fa-edit'></i></button>" +'   '+
                           "<button class='eliminar btn btn-danger btn-sm' onclick='Eliminar_Area(" + row.id + ")'><i class='fas fa-trash'></i></button>";
                }
            }
        ],
        "language": idioma_espanol,
        select: true
    });

    tbl_areas.on('draw.td', function () {
        var PageInfo = $("#tbl_area").DataTable().page.info();
        tbl_areas.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

function AbrirModalRegistroArea() {
    LimpiarModalArea();
    $("#modal_registro_area").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $("#modal_registro_area").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

function ValidarInput(nombre, responsable) {
    if (nombre != "") {
        Boolean(document.getElementById(nombre).value.length > 0) ? $("#" + nombre).removeClass("is-invalid").addClass("is-valid")
            : $("#" + nombre).removeClass("is-valid").addClass("is-invalid");
    }
    if (responsable != "") {
        Boolean(document.getElementById(responsable).value.length > 0) ? $("#" + responsable).removeClass("is-invalid").addClass("is-valid")
            : $("#" + responsable).removeClass("is-valid").addClass("is-invalid");
    }
}

function LimpiarModalArea() {
    document.getElementById('txt_nombre').value = "";
    document.getElementById('txt_responsable').value = "";

}

// Funcion Registrar areas en la BD
function Registrar_Area() {
    let nombre = document.getElementById('txt_nombre').value;
    let responsable = document.getElementById('txt_responsable').value;

    if (nombre === "" || responsable === "") {
        return Swal.fire("Mensaje de Advertencia", "Tiene campos vacios", "warning");
    }
    $.ajax({
        // Ruta absoluta
        //'http://localhost/inventario_belen/controllers/areas/registrar_area.php',
        // Ruta Relativa
        url: '../controllers/areas/registrar_area.php',
        type: 'POST',
        data: {
            nombre: nombre,
            responsable: responsable
        },
        dataType: 'json'
    }).done(function (resp) {
        //console.log(resp);
        if (resp.status === "exist") {
            // Área ya se encuentra registrada
            Swal.fire("Área Existente", "El Área ya se encuentra registrada", "warning");
        } else if (resp.status === "success") {
            // Área registrada correctamente
            Swal.fire("Mensaje de Confirmación", "Nueva Área registrada", "success")
                .then((value) => {
                    $("#modal_registro_area").modal('hide');
                    tbl_areas.ajax.reload();
                });
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al procesar la solicitud:", textStatus, errorThrown);
    });
}

// Abrir el modal de Modificar y cargar los datos de acuerdo a cada area
$('#tbl_area').on('click', '.editar', function () {
    var data = tbl_areas.row($(this).parents('tr')).data();

    if (tbl_areas.row(this).child.isShown()) {
        var data = tbl_areas.row(this).data;
    }
    //Abrir Modal para editar Area 
    $("#modal_editar_area").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_area").modal('show');

    document.getElementById('txt_idarea_editar').value      = data.id; //Nombre de tabla segun listar
    document.getElementById('txt_nombre_editar').value      = data.nombre;
    document.getElementById('txt_responsable_editar').value = data.responsable;
})

// Funcion Modificar areas en la BD
function Modificar_Area() {
    let id = document.getElementById('txt_idarea_editar').value;
    let nombre = document.getElementById('txt_nombre_editar').value;
    let responsable = document.getElementById('txt_responsable_editar').value;

    if (responsable.length === 0 || nombre.length === 0 || id.length === 0) {
        return Swal.fire("Mensaje de Advertencia", "Tiene algunos campos vacíos", "warning");
    }

    $.ajax({
        url: '../controllers/areas/modificar_area.php',
        type: 'POST',
        data: {
            id: id,
            nombre: nombre,
            responsable: responsable
        },
        dataType: 'json' // Asegúrate de esperar un JSON como respuesta
    })
    .done(function (resp) {
        //console.log(resp);
        if (resp.status === "success") {
            Swal.fire("Mensaje de Confirmación", "Área actualizada", "success")
                .then((value) => {
                    $("#modal_editar_area").modal('hide');
                    tbl_areas.ajax.reload();
                });
        } else if (resp.status === "exist") {
            Swal.fire("Mensaje de Advertencia", "El área ya se encuentra registrada", "warning");
        } else {
            Swal.fire("Mensaje de Error", "No se pudo actualizar los datos", "error");
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al procesar la solicitud:", textStatus, errorThrown);

        // Muestra un mensaje genérico de error en caso de problemas de comunicación o respuesta no válida
        Swal.fire("Mensaje de Error", "Ocurrió un problema al procesar la solicitud", "error");
    });
}

// Funcion Eliminar areas en la BD
function Eliminar_Area(id) {
    // Puedes mostrar un diálogo de confirmación antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el área. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamada AJAX para eliminar el área
            $.ajax({
                url: '../controllers/areas/eliminar_area.php',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json' // Asegúrate de esperar un JSON como respuesta
            }).done(function (resp) {
                if (resp.status === 'success') {
                    Swal.fire('Eliminado', 'El área ha sido eliminada', 'success').then(() => {
                        // Aquí puedes recargar la tabla o realizar alguna acción adicional
                        // Por ejemplo, recargar la tabla
                        tbl_areas.ajax.reload();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el área', 'error');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error al procesar la solicitud:', textStatus, errorThrown);
                Swal.fire('Error', 'No se pudo eliminar el área', 'error');
            });
        }
    });
}

//////////////////////VALIDACIONES DE CAMPOS//////////////////////////////////
function validaLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚabcdefghijklmnñopqrstuvwxyzáéíóú ";

    especiales = [8,13];
    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]){
        tecla_especial = true;
        break;
        }
    }
    if(letras.indexOf(tecla) == -1 && !tecla_especial)
    {
    alert("Ingresar Solo Letras");
    return false;
    }
}
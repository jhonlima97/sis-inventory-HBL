function Login() {
    let email = document.getElementById('txtEmail').value;
    let pass = document.getElementById('txtPass').value;

    if (email.length === 0 || pass.length === 0) {
        return Swal.fire('Mensaje de Advertencia', 'Ingrese los datos de sesión', 'warning');
    }
    $.ajax({
        url:'http://localhost/inventario_belen/sis-inventory-HBL/controllers/usuario/login.php',
        type: 'POST',
        data: {
            e: email,
            p: pass
        }
    }).done(function (resp) {
        try {
            let data = JSON.parse(resp);
            // console.log("Valor data", data);
            if(data && data.estado==='ACTIVO'){
                redireccionarUsuario(data); //redirigirlo a la pantalla inicial 
            }else if (data && data.error){
                Swal.fire('Mensaje de Advertencia', data.mensaje, 'warning'); //Usuario inactivo o usuario no encontrado/contraseña 
            }else{
                Swal.fire('Mensaje de Error', 'Respuesta inesperada del servidor', 'error');//errores de servidor
            }
        } catch (error) {
            // Error al parsear la respuesta JSON
            Swal.fire('Error', 'Ha ocurrido un error en el servidor', 'error');
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        // Manejo de errores de la solicitud AJAX
        console.log('Error de AJAX:', textStatus, errorThrown);
        Swal.fire('Error', 'Error de AJAX. Detalles: ' + textStatus, 'error');
    });
}

function redireccionarUsuario(userData) {
    $.ajax({
        url: 'http://localhost/inventario_belen/sis-inventory-HBL/controllers/usuario/crear_sesion.php',
        type: 'POST',
        data: {
            id: userData.id,
            nombres: userData.nombres,
            email: userData.email,
            pass_hash: userData.pass_hash,
            rol: userData.rol,
            estado: userData.estado
        }
    }).done(function (r) {
        try {
            let response = JSON.parse(r); // Asegúrate de parsear la respuesta
            if (response.success) {
                mostrarBienvenida();
            }
        } catch (error) {
            Swal.fire('Error', 'No se pudo procesar la respuesta del servidor', 'error');
        }
    }).fail(function (jqXHR, textStatus) {
        Swal.fire('Error', 'Error en la petición AJAX: ' + textStatus, 'error');
    });
}

function mostrarBienvenida() {
    let timerInterval;
    Swal.fire({
        title: 'Bienvenido al Sistema',
        html: 'Redireccionando en <b></b> milliseconds.',
        timer: 2000,
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            location.reload(); // Redirecciona al recargar la página
        }
    });
}

var tbl_usuarios;
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

// Funcion Listar usuarios desde la BD
function listar_usuarios() {
    tbl_usuarios = $("#tbl_usuario").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        // "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            // Modificar la rutas en production
            "url": "../controllers/usuario/listar_usuarios.php",
            type: 'POST'
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "nombres" },
            { "data": "email" },
            {
                "data": "pass_hash",
                render: function (data, type, row) {
                    return "Pass Encriptada";
                }
            },
            { "data": "rol" },
            {
                "data": "estado",

                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return '<span class="badge bg-success">ACTIVO</span>'
                    } else {
                        return '<span class="badge bg-danger">INACTIVO</span>'
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
                    return "<button class='editar btn btn-primary btn-sm'><i class='fas fa-edit'></i></button>";
                }
            }
        ],
        "language": idioma_espanol,
        select: true
    });

    tbl_usuarios.on('draw.td', function () {
        var PageInfo = $("#tbl_usuario").DataTable().page.info();
        tbl_usuarios.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

function AbrirModalRegistroUsuario() {
    $("#modal_registro_usuario").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $("#modal_registro_usuario").modal('show');
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
}

// Funcion Registrar usuarios en la BD
function Registrar_Usuario() {
    let nombres = document.getElementById('txt_nombres').value;
    let email = document.getElementById('txt_email').value;
    let pass = document.getElementById('txt_pass').value;
    let rol = document.getElementById('select_rol').value;
    let pregunta = document.getElementById('txt_pregunta').value;
    let respuesta = document.getElementById('txt_respuesta').value;

    if (nombres === "" || email === "" || pass === "" || rol === "" || pregunta === "" || respuesta==="") {
        return Swal.fire("Mensaje de Advertencia", "Tiene campos vacios", "warning");
    }
    $.ajax({
        url: '../controllers/usuario/registrar_usuario.php',
        type: 'POST',
        data: {
            nombres: nombres,
            email: email,
            pass_hash: pass,
            rol: rol,
            pregunta: pregunta,
            respuesta: respuesta
        },
        dataType: 'json'
    }).done(function (resp) {
        //console.log(resp); // Verifica si recibes el ID del usuario o el mensaje de existencia
        if (resp && resp.status === "exist") {
            Swal.fire("Usuario Existente", "El Usuario ya se encuentra registrado", "warning");
        } else if (resp && resp.status === "success") {
            Swal.fire("Confirmación", "Nuevo Usuario registrado", "success")
                .then((value) => {
                    $("#modal_registro_usuario").modal('hide');
                    tbl_usuarios.ajax.reload();
                });
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al procesar la solicitud:", textStatus, errorThrown);
        Swal.fire("Error", "Hubo un error al procesar la solicitud", "error");
    });
    
    
}

// Abrir el modal de Modificar y cargar los datos de acuerdo a cada usuario
$('#tbl_usuario').on('click', '.editar', function () {
    var data = tbl_usuarios.row($(this).parents('tr')).data();

    if (tbl_usuarios.row(this).child.isShown()) {
        var data = tbl_usuarios.row(this).data;
    }
    //Abrir Modal para editar Usuario 
    $("#modal_editar_usuario").modal({ backdrop: 'static', keyboard: false }) //No cerrar cuando se dé click al costado
    $('.form-control').removeClass("is-invalid").removeClass("is-valid")
    $("#modal_editar_usuario").modal('show');

    document.getElementById('txt_id_editar').value      = data.id; //Nombre de tabla segun listar
    document.getElementById('txt_nombres_editar').value = data.nombres;
    document.getElementById('txt_email_editar').value = data.email;
    document.getElementById('txt_pass_editar').value = data.pass_hash;
    document.getElementById('txt_pregunta_editar').value = data.pregunta;
    document.getElementById('txt_respuesta_editar').value = data.respuesta;
    $("#select_rol_editar").val(data.rol).trigger('change');
    document.getElementById('select_estado_editar').value = data.estado;

})

// Funcion Modificar usuarios en la BD Tiene errores
function Modificar_Usuario() {
    // Verificar que el valor de la clave primaria del registro que estamos modificando sea correcto
    const id = document.getElementById('txt_id_editar').value;
    if (id <= 0) {
        Swal.fire("Mensaje de Advertencia", "El ID del usuario debe ser mayor que 0.", "warning");
        return;
    }
    // Verificar que los campos no estén vacíos
    const nombres = document.getElementById('txt_nombres_editar').value;
    const email = document.getElementById('txt_email_editar').value;
    const pass = document.getElementById('txt_pass_editar').value;
    const rol = document.getElementById('select_rol_editar').value;
    const estado = document.getElementById('select_estado_editar').value;
    const pregunta = document.getElementById('txt_pregunta_editar').value;
    const respuesta = document.getElementById('txt_respuesta_editar').value;

    if (nombres.length === 0 || email.length === 0 || pass.length === 0 || rol.length === 0 || estado.length === 0 || pregunta.length === 0 || respuesta.length === 0) {
        Swal.fire("Mensaje de Advertencia", "Tiene algunos campos vacíos", "warning");
        return;
    }
    // Enviar la solicitud AJAX
    $.ajax({
        url: '../controllers/usuario/modificar_usuario.php',
        //url:'http://localhost/inventario_belen/controllers/usuario/modificar_usuario.php',
        type: 'POST',
        data: {
            id: id,
            nombres: nombres,
            email: email,
            pass_hash: pass,
            rol: rol,
            estado: estado,
            pregunta: pregunta,
            respuesta: respuesta
        },
        dataType: 'json'
    })
    .done(function (resp) {
        if (resp.success) {
            Swal.fire("Mensaje de Confirmación", "Usuario actualizado", "success")
                .then((value) => {
                    $("#modal_editar_usuario").modal('hide');
                    tbl_usuarios.ajax.reload();
                });
        } else {
            if (resp.message.includes("email")) {
                Swal.fire("Mensaje de Advertencia", "El usuario ya se encuentra registrado", "warning");
            } else {
                Swal.fire("Mensaje de Error", resp.message, "error");
            }
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        //console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        console.log("Respuesta completa:", jqXHR.responseText);
        Swal.fire("Mensaje de Error", "Ocurrió un problema al procesar la solicitud", "error");
    });    
}
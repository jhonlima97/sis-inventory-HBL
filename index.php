<?php

session_start();
if (isset($_SESSION['S_ID'])) {
  header('Location: views/index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN | INVENTARIO HBL</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="libs/css/login.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="libs/css/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="libs/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">

</head>

<body class="body-wallpaper">

  <div class="container" id="loginForm">
    <form onsubmit="Login(); return false;" class="form">
        <h2>Iniciar sesión</h2>
        <!-- Campo de correo electrónico -->
        <input type="email" class="input" placeholder="Ingrese su email" id="txtEmail">
        <!-- Campo de contraseña con opción para mostrar/ocultar -->
        <div class="input-container">
            <input type="password" class="input" placeholder="Ingrese su contraseña" id="txtPass" autocomplete="off">
            <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility()" style="cursor: pointer; color:grey;"></i>
        </div>
        <!-- Enlace para recuperar contraseña -->
        <a href="#" onclick="mostrarFormulario('recuperar')">¿Olvidaste tu contraseña?</a>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary" style="margin:5px;">INGRESAR</button>
    </form>

    <!-- Video de fondo o lateral -->
    <div class="side" id="sideLogin">
      <video autoplay loop muted>
        <source src="libs/images/informatic2.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
      </video>
    </div>
  </div>

  <div class="container" id="RecuperarForm" style="display: none;">
    <form class="form" onsubmit="event.preventDefault(); mostrarPreguntaSecreta();">
        <h2>Recuperar Contraseña</h2>
        <!-- Campo de correo electrónico -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="correo">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo" required>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>

        <!-- Pregunta secreta -->
        <div class="input-group" id="preguntaSecreta" style="display: none;">
          <div class="input-group-prepend">
            <label class="input-group-text">Pregunta Secreta:</label>
            <p class="form-control" id="pregunta"></p>
          </div>
          <div class="input-group-prepend">
            <input type="text" class="form-control" id="respuestaInput" placeholder="Ingrese su respuesta" autocomplete="off" style="display: none;">
            <button type="button" class="btn btn-primary" onclick="validarRespuesta()">Validar</button>
          </div>
        </div>
        <hr>

        <!-- Nuevas contraseñas -->
        <div id="nuevasContrasenas" style="display: none;">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Nueva Contraseña:</span>
            </div>
            <input type="password" class="form-control" id="nuevaContrasena" placeholder="Ingrese su nueva contraseña" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Confirmar Contraseña:</span>
            </div>
            <input type="password" class="form-control"  id="confirmarContrasena" placeholder="Confirme su nueva contraseña" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>

            <button type="button" class="btn btn-primary btn-block" onclick="cambiarContrasena()">Cambiar Contraseña</button>
        </div>
        
        <button type="button" class="btn btn-primary" style="margin:5px;" onclick="mostrarFormulario('login')">Cancelar</button>
    </form>

      <div class="side" id="sideRecuperar" style="display: none;">
          <video autoplay loop muted>
              <source src="libs/images/informatic2.mp4" type="video/mp4">
              Tu navegador no soporta el elemento de video.
          </video>
      </div>
  </div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- Bootstrap 4.6 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="libs/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>

<script src="libs/js/login.js?rev=<?php echo time();?>"></script>   <!-- para Volver a recargar el js  -->
<script src="libs/js/usuario.js?rev=<?php echo time();?>"></script>   <!-- para Volver a recargar el js  -->


<script>

  function mostrarFormulario(tipo) {
    if (tipo === 'login') {
        document.getElementById('loginForm').style.display = 'flex';
        document.getElementById('RecuperarForm').style.display = 'none';
        document.getElementById('sideLogin').style.display = 'block';
        document.getElementById('sideRecuperar').style.display = 'none';
        
        // Restablecer los valores de los campos del formulario de recuperación
        document.getElementById('correo').value = '';
        document.getElementById('preguntaSecreta').style.display = 'none';
        document.getElementById('nuevasContrasenas').style.display = 'none';
        document.getElementById('respuestaInput').value = ''; 
        document.getElementById('nuevaContrasena').value = ''; 
        document.getElementById('confirmarContrasena').value = ''; 
    
    } else if (tipo === 'recuperar') {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('RecuperarForm').style.display = 'flex';
        document.getElementById('sideLogin').style.display = 'none';
        document.getElementById('sideRecuperar').style.display = 'block';
    }
  }

  var respuestaBD; // Variable para almacenar la respuesta de la base de datos
  function mostrarPreguntaSecreta() {
    var correo = document.getElementById('correo').value;

    // Envía el correo electrónico al controlador mediante AJAX
    $.ajax({
        type: "POST",
        url: "controllers/usuario/pregunta_secreta.php", // Ruta correcta de tu controlador
        data: { correo: correo },
        dataType: "json",
        success: function(response) {
            // Maneja la respuesta del controlador
            if (response.pregunta) {
                // Almacena la respuesta de la base de datos en la variable
                respuestaBD = response.respuesta;
                // Si se recibió la pregunta secreta, muestra la pregunta en tu formulario
                document.getElementById('preguntaSecreta').style.display = 'block';
                document.getElementById('pregunta').innerHTML = response.pregunta;
                // Habilita el input para que el usuario ingrese su respuesta
                document.getElementById('respuestaInput').style.display = 'block';
                // Habilita el botón para validar la respuesta
                document.getElementById('validarRespuestaBtn').style.display = 'block';
            } else {
                // Si no se recibió ninguna pregunta secreta, muestra un mensaje de error
                Swal.fire({
                    title: "Error",
                    text: "No se pudo obtener la pregunta secreta",
                    icon: "error"
                });
            }
        },
        error: function() {
            // Maneja los errores de la solicitud AJAX
            Swal.fire({
                    title: "Error",
                    text: "Error al procesar la solicitud.",
                    icon: "error"
            });
        }
    });
  }

  function validarRespuesta() {
    // Obtener la respuesta del usuario
    var respuestaUsuario = document.getElementById('respuestaInput').value;

    // Comparar la respuesta del usuario con la respuesta almacenada
    if (respuestaUsuario === respuestaBD) {
        // Las respuestas coinciden, mostrar campos para ingresar nuevas contraseñas
        Swal.fire({
                  title: "Respuesta correcta",
                  text: "Puedes ingresar tus nuevas contraseñas.",
                  icon: "success"
        });
        
        // Mostrar los campos para ingresar las nuevas contraseñas
        document.getElementById('nuevasContrasenas').style.display = 'block';
    } else {
        // Las respuestas no coinciden, mostrar un mensaje de error
        Swal.fire({
                  title: "Respuesta incorrecta",
                  text: "Inténtalo de nuevo",
                  icon: "error"
        });
    }
  }

  function validarContrasenas() {
    var nuevaContrasena = document.getElementById('nuevaContrasena').value;
    var confirmarContrasena = document.getElementById('confirmarContrasena').value;

    if (nuevaContrasena === confirmarContrasena) {
        return true; // Las contraseñas coinciden
    } else {
      Swal.fire({
          title: "Las contraseñas no coinciden",
          text: "Por favor, verifíquelas",
          icon: "error"
      });

        return false; // Las contraseñas no coinciden
    }
  }

  function cambiarContrasena() {
    if (validarContrasenas()) {
        var email = document.getElementById('correo').value;
        var nuevaContrasena = document.getElementById('nuevaContrasena').value;

        // Realizar la solicitud AJAX para cambiar la contraseña
        $.ajax({
            type: "POST",
            url: "controllers/usuario/cambiar_contrasena.php", // Ruta correcta de tu controlador
            data: { email: email, pass_hash: nuevaContrasena },
            dataType: "text",
            success: function(response) {
                // Manejar la respuesta del servidor
               // Mostrar mensaje de éxito o error
               
                Swal.fire({
                    title: "Contraseña actualizada",
                    text: "Inicie sesión con su nueva credencial",
                    icon: "success"
                });
                //if (response.trim() === "Contraseña actualizada correctamente") {
                    window.location.reload(); // Recargar la página
                //}
            },
            error: function() { 
                Swal.fire({
                    title: "Error",
                    text: "Error al procesar la solicitud.",
                    icon: "error"
                });
            }
        });
    }
  }

  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('txtPass');
    const toggleIcon = document.querySelector('.toggle-password');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
  }
</script>

</body>
</html>

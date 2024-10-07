<?php
require '../../models/model_usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["pass_hash"])) {
    $MU = new Model_Usuario(); // Instanciamos el modelo de usuario

    // Obtener los datos del formulario
    $email     = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $pass_hash = password_hash($_POST['pass_hash'], PASSWORD_DEFAULT, ['cost' => 12]);

    // Registrar el usuario
    $consulta = $MU->ActualizarContrasena($email, $pass_hash);

    // Devolver la respuesta al cliente
    echo $consulta;
} else {
    // Si los datos no se reciben correctamente, devolver un mensaje de error
    echo "Error: Datos incompletos";
}
?>

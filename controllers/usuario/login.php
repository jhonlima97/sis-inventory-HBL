<?php
require '../../models/model_usuario.php';

$MU = new Model_Usuario();

$email = htmlspecialchars($_POST['e'], ENT_QUOTES, 'UTF-8');
$pass  = htmlspecialchars($_POST['p'], ENT_QUOTES, 'UTF-8');

$consulta = $MU->VerificarUsuario($email, $pass);

if ($consulta !== null) {
    if ($consulta['estado'] === 'ACTIVO') {
        // Usuario activo, devuelve los datos del usuario
        $respuesta = json_encode($consulta);
        echo $respuesta;
    } else {
        // Usuario no activo
        $respuesta = array("error" => true, "mensaje" => "El usuario no está activo");
        echo json_encode($respuesta);
    }
} else {
    // Usuario no encontrado o contraseña incorrecta
    $respuesta = array("error" => true, "mensaje" => "Usuario no encontrado o contraseña incorrecta");
    echo json_encode($respuesta);
}


?>
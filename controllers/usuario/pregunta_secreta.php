<?php
require '../../models/model_usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["correo"])) {
    $email = $_POST["correo"];
    $MU = new Model_Usuario();
    $consulta = $MU->ObtenerPreguntaSecreta($email); // Cambiar a la nueva función

    if ($consulta) {
        // Devuelve la pregunta y la respuesta secreta como respuesta en formato JSON
        echo json_encode($consulta);
    } else {
        // Devuelve un mensaje de error si no se pudo obtener la pregunta y la respuesta secreta
        echo json_encode(["error" => "No se pudo obtener la pregunta secreta"]);
    }
}
?>

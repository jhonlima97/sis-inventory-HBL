<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require '../../models/model_areas.php';

    if (isset($_POST['id'])) {
        $area_id = $_POST['id'];
        
        $MA = new Model_Areas();
        $consulta = $MA->eliminar_area($area_id);

        // Si la consulta se realizó con éxito
        if ($consulta) {
            echo json_encode(["status" => "success"]);
        } else {
            // Si ocurrió un error durante la eliminación
            echo json_encode(["status" => "error", "message" => "No se pudo eliminar el área"]);
        }
    } else {
        // Si no se proporcionó un ID válido
        echo json_encode(["status" => "error", "message" => "No se proporcionó un ID válido"]);
    }
} else {
    // Si no se recibió una solicitud POST válida
    echo json_encode(["status" => "error", "message" => "Solicitud no válida"]);
}
?>

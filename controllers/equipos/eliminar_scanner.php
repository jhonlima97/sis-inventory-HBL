<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require '../../models/model_scanners.php';

    if (isset($_POST['cod_patrimonial'])) {
        $scan_id = $_POST['cod_patrimonial'];
        
        $MN = new Model_Scanners();
        $consulta = $MN->eliminar_scanner($scan_id);

        // Si la consulta se realizó con éxito
        if ($consulta) {
            echo json_encode(["status" => "success"]);
        } else {
            // Si ocurrió un error durante la eliminación
            echo json_encode(["status" => "error", "message" => "No se pudo eliminar el producto"]);
        }
    } else {
        // Si no se proporcionó un Cod. válido
        echo json_encode(["status" => "error", "message" => "No se proporcionó un ID válido"]);
    }
} else {
    // Si no se recibió una solicitud POST válida
    echo json_encode(["status" => "error", "message" => "Solicitud no válida"]);
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require '../../models/model_servidores.php';

    if (isset($_POST['cod_patrimonial'])) {
        $serv_id = $_POST['cod_patrimonial'];
        
        $MSE = new Model_Servidores();
        $consulta = $MSE->eliminar_servidor($serv_id);

        // Si la consulta se realizó con éxito
        if ($consulta) {
            echo json_encode(["status" => "success"]);
        } else {
            // Si ocurrió un error durante la eliminación
            echo json_encode(["status" => "error", "message" => "No se pudo eliminar el servidor"]);
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

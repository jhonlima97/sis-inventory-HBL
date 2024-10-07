<?php
require '../../models/model_graficos.php';

try {
    // Verificamos si se ha pasado el parámetro 'accion' para definir qué consulta realizar
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    $MG = new Model_Graficos(); // Instanciamos el modelo

    if ($accion === 'num_equipos') {
        // Llamada al método getNumEquipos
        $consulta = $MG->getNumEquipos();
    } elseif ($accion === 'grafico_params') {
        // Llamada al método getGraficoParams con el parámetro 'anio'
        $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
        $consulta = $MG->getGraficoParams($anio);
    } else {
        // Acción no especificada o incorrecta
        throw new Exception("Acción no válida");
    }

    // Devolvemos la respuesta en formato JSON
    echo json_encode($consulta);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

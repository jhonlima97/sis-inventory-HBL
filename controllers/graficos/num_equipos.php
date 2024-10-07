<?php
require '../../models/model_graficos.php';

try {
    $MG = new Model_Graficos(); // Instanciamos
    $consulta = $MG->getNumEquipos(); 
    echo json_encode($consulta); 
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

<?php
require '../../models/model_scanners.php';

$MN = new Model_Scanners();
$consulta = $MN->listar_scanners();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>
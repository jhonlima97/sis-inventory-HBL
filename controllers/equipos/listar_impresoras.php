<?php
require '../../models/model_impresoras.php';

$MI = new Model_Impresoras();
$consulta = $MI->listar_impresoras();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>
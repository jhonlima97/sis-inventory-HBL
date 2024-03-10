
<?php
require '../../models/model_areas.php';

$MA = new Model_Areas();
$consulta = $MA->listar_areas();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>

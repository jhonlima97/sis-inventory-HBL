
<?php
require '../../models/model_switches.php';

$MS = new Model_Switches();
$consulta = $MS->listar_switches();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>


<?php
require '../../models/model_perifericos.php';

$MP = new Model_Perifericos();
$consulta = $MP->listar_perifericos();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>

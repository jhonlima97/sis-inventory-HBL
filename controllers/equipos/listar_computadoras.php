
<?php
require '../../models/model_computadoras.php';

$MU = new Model_Computadoras();
$consulta = $MU->listar_computadoras();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>

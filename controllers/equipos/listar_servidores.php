
<?php
require '../../models/model_servidores.php';

$MSE = new Model_Servidores();
$consulta = $MSE->listar_servidores();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>


<?php
require '../../models/model_usuario.php';

$MU = new Model_Usuario();
$consulta = $MU->listar_usuarios();

if ($consulta) {
    echo json_encode($consulta);
} else {
    // Devuelve un array vacío
    echo json_encode([]);
}
?>

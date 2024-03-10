<?php
require_once '../../models/model_desplazamiento.php';


$cod_desp = htmlspecialchars($_POST['cod_desp'], ENT_QUOTES, 'UTF-8');
//$cod_desp = 36;

// Realiza la búsqueda en la base de datos según el tipoBien y codPatrimonial
$objClase = new Model_Desplazamiento();

$consulta = $objClase->listar_Detalle_equipos($cod_desp);


if ($consulta) {
    echo json_encode($consulta);
} else {
    echo json_encode([]);
}

?>

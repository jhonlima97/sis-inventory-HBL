
<?php
require_once '../../models/model_desplazamiento.php';

// Recibe los datos del formulario
$tipoBien = $_POST['tipoBien'];
$codPatrimonial = $_POST['codPatrimonial'];

// Realiza la búsqueda en la base de datos según el tipoBien y codPatrimonial
$objClase = new Model_Desplazamiento();
$consulta = $objClase->getRegistroPorCodigoPatrimonial($tipoBien,$codPatrimonial);

if ($consulta) {
    echo json_encode($consulta);
} else {
    echo json_encode([]);
}

?>

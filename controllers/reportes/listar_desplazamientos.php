<?php
require '../../models/model_desplazamiento.php';



$MU = new Model_Desplazamiento();
$consulta = $MU->listar_desplazamientos();
echo json_encode($consulta)


?>

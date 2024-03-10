<?php
require '../../models/model_desplazamiento.php';

$MI = new Model_Desplazamiento();

// Obtener los detalles de los equipos del POST
$detallesEquipos = $_POST['detalles_equipos'];

// Obtener los demás datos del POST
$motivo = htmlspecialchars($_POST['motivo'], ENT_QUOTES, 'UTF-8');
$area_prov = htmlspecialchars($_POST['area_prov'], ENT_QUOTES, 'UTF-8');
$resp_prov = htmlspecialchars($_POST['responsable_prov'], ENT_QUOTES, 'UTF-8');
$area_asig = htmlspecialchars($_POST['area_asig'], ENT_QUOTES, 'UTF-8');
$resp_asig = htmlspecialchars($_POST['responsable_asig'], ENT_QUOTES, 'UTF-8');
$fecha = htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8');

// Llamar a la función del modelo para registrar el desplazamiento
$consulta = $MI->registrar_asignacion_despl($motivo, $area_prov, $resp_prov, $area_asig, $resp_asig, $fecha, $detallesEquipos);
echo $consulta;
?>

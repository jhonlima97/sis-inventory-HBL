<?php
require '../../models/model_switches.php';

$MS = new Model_Switches(); // Instanciamos

$codigo     = htmlspecialchars($_POST['cod_patrimonial'], ENT_QUOTES, 'UTF-8');
$nombre    = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
$marca      = htmlspecialchars($_POST['marca'], ENT_QUOTES, 'UTF-8');
$modelo     = htmlspecialchars($_POST['modelo'], ENT_QUOTES, 'UTF-8');
$serie      = htmlspecialchars($_POST['serie'], ENT_QUOTES, 'UTF-8');
$puerto         = htmlspecialchars($_POST['puertos'], ENT_QUOTES, 'UTF-8');
$area       = htmlspecialchars($_POST['area_id'], ENT_QUOTES, 'UTF-8');
$estado     = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');

// Corrige el orden de los parámetros
$consulta = $MS->modificar_switch($codigo,$nombre, $marca,$modelo,$serie, $puerto,$area, $estado);


?>



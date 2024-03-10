<?php
require '../../models/model_computadoras.php';

$MU = new Model_Computadoras(); // Instanciamos

$codigo     = htmlspecialchars($_POST['cod_patrimonial'], ENT_QUOTES, 'UTF-8');
$marca      = htmlspecialchars($_POST['marca'], ENT_QUOTES, 'UTF-8');
$modelo     = htmlspecialchars($_POST['modelo'], ENT_QUOTES, 'UTF-8');
$serie      = htmlspecialchars($_POST['serie'], ENT_QUOTES, 'UTF-8');
$so         = htmlspecialchars($_POST['sis_ope'], ENT_QUOTES, 'UTF-8');
$ip         = htmlspecialchars($_POST['ip'], ENT_QUOTES, 'UTF-8');
$procesador = htmlspecialchars($_POST['procesador'], ENT_QUOTES, 'UTF-8');
$ram        = htmlspecialchars($_POST['ram'], ENT_QUOTES, 'UTF-8');
$disco      = htmlspecialchars($_POST['disco'], ENT_QUOTES, 'UTF-8');
$area       = htmlspecialchars($_POST['area_id'], ENT_QUOTES, 'UTF-8');
$estado     = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');

// Corrige el orden de los parámetros
$consulta = $MU->modificar_computadora($codigo, $marca,$modelo,$serie, $so, $ip, $procesador, $ram, $disco, $area, $estado);


?>



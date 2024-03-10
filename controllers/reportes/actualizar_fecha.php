<?php
require '../../models/model_desplazamiento.php';

$MD = new Model_Desplazamiento(); // Instanciamos

$id     = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$fecha      = htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8');

// Corrige el orden de los parámetros
$consulta = $MD->Actualizar_Fecha($id, $fecha);


?>
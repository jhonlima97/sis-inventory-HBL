<?php
require '../../models/model_usuario.php';

$MU = new Model_Usuario(); // Instanciamos

$id         = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$nombres    = htmlspecialchars($_POST['nombres'], ENT_QUOTES, 'UTF-8');
$email      = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
//La función isset en PHP se utiliza para comprobar si una variable está definida y no es nula
$pass_hash = !empty($_POST['pass_hash']) ? password_hash($_POST['pass_hash'], PASSWORD_DEFAULT, ['cost' => 12]) : null;
//$pass_hash  = password_hash($_POST['pass_hash'], PASSWORD_DEFAULT, ['cost' => 12]);
$rol        = htmlspecialchars($_POST['rol'], ENT_QUOTES, 'UTF-8');
$estado     = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');
$pregunta        = htmlspecialchars($_POST['pregunta'], ENT_QUOTES, 'UTF-8');
$respuesta     = htmlspecialchars($_POST['respuesta'], ENT_QUOTES, 'UTF-8');

// Corrige el orden de los parámetros
$consulta = $MU->modificar_usuario($id, $nombres, $email, $pass_hash, $rol, $estado, $pregunta, $respuesta);
?>
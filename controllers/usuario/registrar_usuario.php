<?php
    require '../../models/model_usuario.php';
    
    $MU = new Model_Usuario();//Instanciamos
    //Convierte todo el string a MAYUSCULAS
    //$nombres    = strtoupper(htmlspecialchars($_POST['nombres'],ENT_QUOTES,'UTF-8'));

    $nombres    = htmlspecialchars($_POST['nombres'],ENT_QUOTES,'UTF-8');
    $email      = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    $pass_hash  = password_hash($_POST['pass_hash'], PASSWORD_DEFAULT,['cost'=>12]);
    $rol        = htmlspecialchars($_POST['rol'],ENT_QUOTES,'UTF-8');
    $pregunta   = htmlspecialchars($_POST['pregunta'],ENT_QUOTES,'UTF-8');
    $respuesta   = htmlspecialchars($_POST['respuesta'],ENT_QUOTES,'UTF-8');

    $consulta = $MU->registrar_usuario($nombres, $email,$pass_hash, $rol,$pregunta,$respuesta); 
    
    echo $consulta;
    
?>
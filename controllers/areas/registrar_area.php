<?php
    require '../../models/model_areas.php';
    
    $MA = new Model_Areas();//Instanciamos

    $nombre      = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $responsable = htmlspecialchars($_POST['responsable'],ENT_QUOTES,'UTF-8');

    $consulta = $MA->registrar_area($nombre, $responsable); 
    
    echo $consulta;
    
?>
<?php
    
    require '../../models/model_areas.php';
    
    $MA = new Model_Areas();//Instanciamos

    $id         = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $nombre     = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $responsable = htmlspecialchars($_POST['responsable'],ENT_QUOTES,'UTF-8');
    
    $consulta = $MA->modificar_area($responsable, $nombre,$id); 
    
    echo $consulta;
    
?>
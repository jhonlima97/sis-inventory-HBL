<?php
    require '../../models/model_switches.php';
    
    $MS = new Model_Switches();//Instanciamos
    
    $cod_patrimonial= htmlspecialchars($_POST['cod_patrimonial'],ENT_QUOTES,'UTF-8');
    $nombre     = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $marca      = htmlspecialchars($_POST['marca'],ENT_QUOTES,'UTF-8');
    $modelo     = htmlspecialchars($_POST['modelo'],ENT_QUOTES,'UTF-8');
    $serie      = strtoupper(htmlspecialchars($_POST['serie'],ENT_QUOTES,'UTF-8'));
    $puerto    = htmlspecialchars($_POST['puertos'],ENT_QUOTES,'UTF-8');
    $area       = htmlspecialchars($_POST['area_id'],ENT_QUOTES,'UTF-8');
    $estado     = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->registrar_switch(
                                    $cod_patrimonial,$nombre,$marca,$modelo,$serie,
                                    $puerto,$area,$estado); 
    
    echo $consulta;
    
?>
<?php
    require '../../models/model_perifericos.php';
    
    $MP = new Model_Perifericos();
    
    $cod_patrimonial= htmlspecialchars($_POST['cod_patrimonial'],ENT_QUOTES,'UTF-8');
    $nombre     = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $marca      = htmlspecialchars($_POST['marca'],ENT_QUOTES,'UTF-8');
    $modelo     = htmlspecialchars($_POST['modelo'],ENT_QUOTES,'UTF-8');
    $serie      = strtoupper(htmlspecialchars($_POST['serie'],ENT_QUOTES,'UTF-8'));
    $area    = htmlspecialchars($_POST['area_id'],ENT_QUOTES,'UTF-8');
    $estado       = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');

    $consulta = $MP->registrar_periferico(
                                    $cod_patrimonial,$nombre, $marca,$modelo,$serie,
                                    $area,$estado); 
    
    echo $consulta;
    
?>
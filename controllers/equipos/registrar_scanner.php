<?php
    require '../../models/model_scanners.php';
    
    $MN = new Model_Scanners();//Instanciamos
    
    $cod_patrimonial = htmlspecialchars($_POST['cod_patrimonial'],ENT_QUOTES,'UTF-8');
    $marca             = htmlspecialchars($_POST['marca'],ENT_QUOTES,'UTF-8');
    $modelo            = htmlspecialchars($_POST['modelo'],ENT_QUOTES,'UTF-8');
    $serie             = strtoupper(htmlspecialchars($_POST['serie'],ENT_QUOTES,'UTF-8'));
    $sis_ope           = htmlspecialchars($_POST['sistema_operativo'],ENT_QUOTES,'UTF-8');
    $velocidad         = htmlspecialchars($_POST['velocidad'],ENT_QUOTES,'UTF-8');
    $resolucion        = htmlspecialchars($_POST['resolucion'],ENT_QUOTES,'UTF-8');
    $area              = htmlspecialchars($_POST['area_id'],ENT_QUOTES,'UTF-8');
    $estado            = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');

    $consulta = $MN->registrar_scanner(
                                    $cod_patrimonial, $marca, $modelo, $serie, $sis_ope,
                                    $velocidad, $resolucion, $area, $estado); 
    
    echo $consulta;
    
?>
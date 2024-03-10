<?php
    require '../../models/model_impresoras.php';
    
    $MI = new Model_Impresoras();
    
    $cod_patrimonial= htmlspecialchars($_POST['cod_patrimonial'],ENT_QUOTES,'UTF-8');
    $marca      = htmlspecialchars($_POST['marca'],ENT_QUOTES,'UTF-8');
    $modelo     = htmlspecialchars($_POST['modelo'],ENT_QUOTES,'UTF-8');
    $serie      = strtoupper(htmlspecialchars($_POST['serie'],ENT_QUOTES,'UTF-8'));
    $num_toner    = htmlspecialchars($_POST['num_toner'],ENT_QUOTES,'UTF-8');
    $area    = htmlspecialchars($_POST['area_id'],ENT_QUOTES,'UTF-8');
    $estado       = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');

    $consulta = $MI->registrar_impresora(
                                    $cod_patrimonial,$marca,$modelo,$serie,
                                    $num_toner,$estado,$area); 
    
    echo $consulta;
    
?>
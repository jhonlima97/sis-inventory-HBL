<?php
    require '../../models/model_desplazamiento.php';
    
    $objClase = new Model_Desplazamiento();
    
    try{
        $resultado = $objClase->obtener_ultimo_codigo_periferico();
    }
    catch (Exception $exc)
    {
        echo $exc->getMessage();
    }
    
    echo $resultado;;
?>

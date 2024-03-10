<?php
    require '../../models/model_graficos.php';
    
    $MG = new Model_Graficos();//Instanciamos

    $consulta = $MG->getNumEquipos(); 
    
    echo json_encode($consulta);

    
?>
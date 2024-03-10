<?php
    require '../../models/model_graficos.php';
    $anio = $_POST['anio'];
    $MG = new Model_Graficos();//Instanciamos

    $consulta = $MG->getGraficoParams($anio); 
    
    echo json_encode($consulta); 
?>
<?php
    require_once '../../models/model_computadoras.php';
    
    $modal = $_GET["modal"];
    $objClase = new Model_Computadoras();
    
    try
    {
        $resultado = $objClase->llenarSelectAreas();
      
    }
    catch (Exception $exc)
    {
        //Funciones::mensaje($exc->getMessage(), "e", "", 0);
        echo $exc->getMessage();
    }
    
    if ($modal == "0"){
        echo '<option value="0"> Seleccione Una... </option>';
    }    
    for ($i=0; $i<count($resultado); $i++) {
        echo '<option value="'.$resultado[$i]["id"].'">'.$resultado[$i]["nombre"].'</option>';
    }   

?>
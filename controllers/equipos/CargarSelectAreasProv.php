<?php
    require_once '../../models/model_desplazamiento.php';
    
    $modal = $_GET["modal"];
    $objClase = new Model_Desplazamiento();
    
    try
    {
        $resultado = $objClase->llenarSelectAreas1();
      
    }
    catch (Exception $exc)
    {
        //Funciones::mensaje($exc->getMessage(), "e", "", 0);
        echo $exc->getMessage();
    }
    
    //if ($modal == "0"){
        echo '<option value="0"> Seleccione Una... </option>';
    //}    
    for ($i=0; $i<count($resultado); $i++) {
        echo '<option value="'.$resultado[$i]["id"].'">'.$resultado[$i]["nombre"].'</option>';
    }   

    // ... Tu código para obtener las áreas ...



?>
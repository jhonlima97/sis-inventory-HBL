<?php
require '../../models/model_desplazamiento.php';

//$tabla = 'computadoras';

$nom_area = isset($_GET['nom_area']) ? $_GET['nom_area'] : 'Administración';

    $objClase = new Model_Desplazamiento();
    
    try{
        $resultado = $objClase->obtener_nombre_responsable_por_area($nom_area);
    }
    catch (Exception $exc)
    {
        echo $exc->getMessage();
    }
    
    echo $resultado;;
?>

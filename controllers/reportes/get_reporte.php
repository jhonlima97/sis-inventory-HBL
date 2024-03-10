<?php
require '../../models/model_reportes.php';

// Verificar si se ha enviado la tabla y asignar un valor predeterminado si no se ha proporcionado
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : 'computadoras';

$MR = new Model_Reportes();

// Dependiendo de la tabla seleccionada, ejecutar la consulta correspondiente
switch ($tabla) {
    case 'COMPUTADORAS':
        $consulta = $MR->getCompusMalas();
        break;
    case 'IMPRESORAS':
        $consulta = $MR->getImpresorasMalas();
        break;
    case 'SERVIDORES':
        $consulta = $MR->getServidoresMalos();
        break;
    case 'SWITCHES':
        $consulta = $MR->getSwitchesMalos();
        break;
    case 'PERIFERICOS':
        $consulta = $MR->getPerifericosMalos();
        break;
    case 'SCANNERS':
        $consulta = $MR->getScannersMalos();
        break;
    default:
        // Opción predeterminada o manejo de errores
        $consulta = [];
        break;
}

if ($consulta) {
    echo json_encode($consulta);
} else {
    echo json_encode([]);
}
?>

<?php
    ob_start(); // Inicia el almacenamiento en búfer de salida
    session_start();
    session_destroy();
    session_unset();
    header("Location: ../../index.php");
    ob_end_flush(); 

?>


